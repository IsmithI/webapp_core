<?php
/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 23.12.18
 * Time: 23:13
 */

namespace Core\validator;

use Core\collection\Collection;
use Core\model\Model;

class Validator
{

    /**
     * @var Model $model
     */
    private $model;


    /**
     * @var Collection $rules
     */
    private $rules;

    /**
     * Validator constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->rules = new Collection();
    }

    public function add(\Closure $rule) {
        $this->rules->push($rule);
        return $this;
    }

    public function isString(string $key) {
        return new StringValidatorBuilder(
            $key,
            $this->add(
                function (Model $model) use ($key) {
                    return $model->has($key) && is_string($model->$key);
                }
            )
        );
    }

    public function isEmail(string $key) {
        return $this->add(
            function (Model $model) use ($key) {
                return $model->has($key) && is_string($model->$key) && count(explode("@", $model->$key)) > 0;
            }
        );
    }

    public function isNumber(string $key) {
        return new NumberValidatorBuilder(
            $key,
            $this->add(
                function (Model $model) use ($key) {
                    return $model->has($key) && is_numeric($model->$key);
                }
            )
        );
    }

    public function isTrue(string $key) {
        return $this->add(function (Model $model) use ($key) {
            return $model->has($key) && $model->$key;
        });
    }

    public function isNotNull(string $key) {
        return $this->add(function (Model $model) use ($key) {
            return $model->has($key) && !is_null($model->$key);
        });
    }

    public function validate() {
        foreach ($this->rules as $rule) {
            if (!$rule($this->model)) return false;
        }
        return true;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param Model $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return Collection
     */
    public function getRules(): Collection
    {
        return $this->rules;
    }

    /**
     * @param Collection $rules
     */
    public function setRules(Collection $rules): void
    {
        $this->rules = $rules;
    }



}