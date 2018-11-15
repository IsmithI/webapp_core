<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:02
 */

namespace app\repository;


use app\collection\Collection;
use app\model\Model;
use app\utils\DB;

class AbstractRepository implements Repository {

    private $table;
    private $db;

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
        foreach ($rawData as $data) $models->push(new Model($data));

        return $models;
    }

    /**
     * @param Model $model
     */
    public function save(Model $model)
    {
        if (!$model->has("id"))
            $this->db->insert($this->getTable(), $model->toArray());
        else
            $this->db->update($this->getTable(), $model->toArray(), ["id" => $model->id]);
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


    public function byId($id): \Closure {
        return function ($model) use ($id) {
            if (is_array($id))
                return in_array($model->id, $id);
            else
                return $model->id == $id;
        };
    }

}