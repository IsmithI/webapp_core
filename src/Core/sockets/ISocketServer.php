<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 16.12.18
 * Time: 17:03
 */

namespace Core\sockets;


interface ISocketServer
{
    public function start();
    public static function init();
}