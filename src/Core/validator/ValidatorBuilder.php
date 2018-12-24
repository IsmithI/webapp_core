<?php
/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 24.12.18
 * Time: 11:21
 */

namespace Core\validator;


interface ValidatorBuilder
{

    public function and(): Validator;
}