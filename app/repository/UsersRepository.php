<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.11.18
 * Time: 22:39
 */

namespace app\repository;


use app\model\Users;

class UsersRepository extends AbstractRepository {

    public function __construct() {
        parent::__construct("users");

        $this->setAutoFormat(true);
        $this->setFormat(Users::getFormat());
    }


}