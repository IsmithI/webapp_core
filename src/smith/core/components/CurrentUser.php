<?php

namespace smith\core\components;

use smith\core\collection\Collection;
use smith\core\middleware\JWTAuth;
use smith\core\model\Users;
use smith\core\repository\UsersRepository;
use Firebase\JWT\JWT;

class CurrentUser implements Component {

    function getName(): string
    {
        return 'user';
    }

    function getHandler(): \Closure
    {
        return function ($req, $res, $service, $app) {
            $headers = new Collection($req->headers()->all());

            $token = $headers->get('Token');

            try {
                $decoded = JWT::decode($token, JWTAuth::KEY, ['HS256']);
            }
            catch (\Exception $e) {
                return false;
            }

            $repo = new UsersRepository();

            $user = $repo->all()->find(function ($u) use ($decoded) {
                return $u->id == $decoded->id;
            });

            return $user;
        };
    }
}