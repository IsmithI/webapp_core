<?php

namespace app\components;

use app\collection\Collection;
use app\middleware\JWTAuth;
use app\model\Users;
use app\repository\UsersRepository;
use Firebase\JWT\JWT;

class CurrentUser {

	public $name = 'user';

	public function __construct() {
		
		$this->handler = function ($req, $res, $service, $app) {
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