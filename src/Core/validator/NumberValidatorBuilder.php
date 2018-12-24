<?php
/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 24.12.18
 * Time: 11:21
 */

namespace Core\validator;


use Core\model\Model;

class NumberValidatorBuilder extends AbstractValidatorBuilder
{

    public function isPositive() {
        $this->predicates->push( function (Model $model) {
            $key = $this->key;
            return (int) $model->$key > 0;
        });

        return $this;
    }

    public function inRange(int $min, int $max) {
        $this->predicates->push( function (Model $model) use ($min, $max) {
            $key = $this->key;

            return (int) $model->$key > $min && (int) $model->$key < $max;
        });

        return $this;
    }
}