<?php
/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 24.12.18
 * Time: 11:22
 */

namespace Core\validator;


use Core\collection\Collection;

abstract class AbstractValidatorBuilder implements ValidatorBuilder
{

    /**
     * @var Validator $validator
     */
    protected $validator;

    /**
     * @var Collection $predicates
     */
    protected $predicates;


    /**
     * @var string $key
     */
    protected $key;

    /**
     * StringValidatorBuilder constructor.
     * @param string $key
     * @param Validator $validator
     */
    public function __construct(string $key, Validator $validator)
    {
        $this->validator = $validator;
        $this->key = $key;
        $this->predicates = new Collection();
    }

    public function and(): Validator {
        $this->predicates->each(function ($p) {
            $this->validator->add($p);
        });

        return $this->validator;
    }


}