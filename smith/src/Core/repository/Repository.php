<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:01
 */

namespace Core\repository;


use Core\collection\Collection;
use Core\model\Model;

interface Repository {

    public function all(): Collection;
    public function save(Model $model);
    public function delete($id);

}