<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:01
 */

namespace smith\core\repository;


use smith\core\collection\Collection;
use smith\core\model\Model;

interface Repository {

    public function all(): Collection;
    public function save(Model $model);
    public function delete($id);

}