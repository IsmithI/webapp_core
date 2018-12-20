<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:02
 */

namespace Core\repository;


use Core\collection\Collection;
use Core\model\Model;
use Core\utils\DB;

class AbstractRepository implements Repository {

    private $table;
    private $db;

    /**
     * Model to format record's data to specific types
     *
     * @var Model $format
     */
    private $format;
    private $autoFormat = false;

    /**
     * AbstractRepository constructor.
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->db = DB::getInstance();
    }


    public function all(): Collection {
        $rawData = $this->db->select($this->getTable(), '*');

        $models = new Collection();
        foreach ($rawData as $data) {
            $model = new Model($data);

            if ($this->isAutoFormat()) $model->format($this->getFormat());

            $models->push($model);
        }

        return $models;
    }

    public function query() {
        return new QueryBuilder($this);
    }

    /**
     * @param Model $model
     */
    public function save(Model $model)
    {
        $newModel = $this->formatToSave($model);
        if (!$newModel->has("id")) {
            $this->db->insert($this->getTable(), $newModel->toArray());
            $newModel->id = (int) $this->db->id();

            $model->id = $newModel->id;
        }
        else
            $this->db->update($this->getTable(), $newModel->toArray(), ["id" => $newModel->id]);
    }

    public function delete($id)
    {
        $this->db->delete($this->getTable(), ['id' => $id]);
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


    /**
     * @param $id
     * @return Model|bool
     */
    public function getById($id) {
        return $this->query()->where(['id' => $id])->get();
    }

    /**
     * @return Model
     */
    public function getFormat(): Model
    {
        return $this->format ? $this->format : new Model();
    }

    /**
     * @param Model $format
     */
    public function setFormat(Model $format)
    {
        $this->format = $format;
    }

    /**
     * @return bool
     */
    public function isAutoFormat(): bool
    {
        return $this->autoFormat;
    }

    /**
     * @param bool $autoFormat
     */
    public function setAutoFormat(bool $autoFormat)
    {
        $this->autoFormat = $autoFormat;
    }

    /**
     * @return DB|null
     */
    public function getDb(): ?DB
    {
        return $this->db;
    }

    public function formatToSave(Model $model) {
        return (new Model($model->toArray()))->format($this->getDBFormat());
    }

    public function getDBFormat(): Model {
        return new Model([
            "attributes" => "to_json"
        ]);
    }

}