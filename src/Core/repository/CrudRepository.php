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

class CrudRepository extends AbstractRepository {

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
}