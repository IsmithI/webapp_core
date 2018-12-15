<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.12.18
 * Time: 15:47
 */

namespace smith\core\components;


interface Component
{
    function getName(): string;
    function getHandler(): \Closure;
}