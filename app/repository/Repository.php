<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:01
 */

namespace app\repository;


use app\collection\Collection;
use app\model\Model;

interface Repository {

    public function all(): Collection;
    public function save(Model $model);
    public function delete($id);

}