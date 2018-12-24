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
use Core\utils\DB;

class QueryBuilder {

    /**
     * @var AbstractRepository $repository
     */
    private $repository;

    private $fields = '*';
    private $where = [];

    private $relatedRepositories;

    /**
     * QueryBuilder constructor.
     * @param AbstractRepository $repository
     */
    public function __construct(AbstractRepository $repository) {
        $this->repository = $repository;
        $this->relatedRepositories = new Model();
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

            $this->injectTo($model);

            $records->push($model);
        }

        return $records;
    }

    public function inject(AbstractRepository $repository) {
        $key = $repository->getTable();
        $this->relatedRepositories->$key = $repository;

        return $this;
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

        $this->injectTo($model);

        return $model;
    }

    private function injectTo(Model $model) {
        foreach ($this->relatedRepositories as $table => $repository) {
            $relationTable = $this->repository->getTable() . "_" . $table;

            $relations = DB::getInstance()->select($relationTable, [
                $table . "_id"
            ], [
                $this->repository->getTable() . "_id" => $model->id
            ]);

            $ids = [];
            foreach ($relations as $relation)
                $ids[] = $relation[$repository->getTable() . "_id"];

            $records = $repository->query()->where(["id" => $ids])->retrieve();

            $model->$table = $records;
        }
    }
}