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

abstract class AbstractRepository implements Repository {

    protected $table;
    protected $db;

    /**
     * Model to format record's data to specific types
     *
     * @var Model $format
     */
    protected $format;
    protected $autoFormat = false;

    /**
     * AbstractRepository constructor.
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
        $this->db = DB::getInstance();
    }


    public abstract function all(): Collection;

    public function query() {
        return new QueryBuilder($this);
    }

    /**
     * @param Model $model
     */
    public abstract function save(Model $model);

    public abstract function delete($id);

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