<?php
/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 24.12.18
 * Time: 0:01
 */

namespace Core\validator;

use Core\model\Model;

class StringValidatorBuilder extends AbstractValidatorBuilder
{

    public function lengthIs(int $length) {
        $this->predicates->push(function (Model $model) use ($length) {
            $key = $this->key;
            return strlen($model->$key) == $length;
        });

        return $this;
    }

    public function lengthIsBetween(int $min, int $max) {
        $this->predicates->push(function(Model $model) use ($min, $max) {
            $key = $this->key;
            return strlen($model->$key) > $min && strlen($model->$key) < $max;
        });

        return $this;
    }

}