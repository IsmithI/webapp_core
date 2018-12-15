<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10.12.18
 * Time: 16:11
 */

namespace Core\repository;


use Core\collection\Collection;
use Core\model\Model;

class QueryBuilder {

    /**
     * @var AbstractRepository $repository
     */
    private $repository;

    private $fields = '*';
    private $where = [];

    /**
     * QueryBuilder constructor.
     * @param AbstractRepository $repository
     */
    public function __construct(AbstractRepository $repository) {
        $this->repository = $repository;
    }

    public function fields($fields) {
        $this->fields = $fields;
        return $this;
    }

    public function where($where) {
        $this->where = $where;
        return $this;
    }

    public function orderBy($orderBy) {
        $this->where["ORDER"] = $orderBy;
        return $this;
    }

    public function limit($limit) {
        $this->where["LIMIT"] = $limit;
        return $this;
    }

    public function retrieve(): Collection {
        $data = $this->repository->getDb()->select(
            $this->repository->getTable(),
            $this->fields,
            $this->where
        );
        $records = new Collection();

        foreach ($data as $record) {
            $model = new Model($record);

            if ($this->repository->isAutoFormat()) $model = $model->format($this->repository->getFormat());

            $records->push($model);
        }

        return $records;
    }

    /**
     * @return bool|Model
     */
    public function get() {
        $data = $this->repository->getDb()->get(
            $this->repository->getTable(),
            $this->fields,
            $this->where
        );

        if (!$data) return false;

        $model = new Model($data);

        if ($this->repository->isAutoFormat()) $model = $model->format($this->repository->getFormat());

        return $model;
    }
}