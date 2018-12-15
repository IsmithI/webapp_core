<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 15.12.18
 * Time: 15:47
 */

namespace Core\components;


interface Component
{
    function getName(): string;
    function getHandler(): \Closure;
}