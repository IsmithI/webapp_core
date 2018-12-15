<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 07.12.18
 * Time: 16:12
 */

namespace smith\core\middleware;


use smith\core\collection\Collection;
use smith\core\controller\response\Error;
use smith\core\model\Users;
use smith\core\utils\DB;
use Firebase\JWT\JWT;

class JWTAuth implements Middleware {

    const KEY = 'SECRET';

    public function handle($req = null, $res = null, $service = null, $app = null) {
        $headers = new Collection($req->headers()->all());

        $token = $headers->get('Token');

        try {
            $user = new Users((array) JWT::decode($token, self::KEY, ['HS256']));
            if (!$user->has('secret')) return new Error($res, 'Invalid token!');

            $db = DB::getInstance();
            $res = $db->has('sessions', [
                'user_id' => $user->id,
                'session_id' => $user->secret
            ]);

            if (!$res) return new Error($res, 'Invalid token!');
        }
        catch (\Exception $e) {
            return new Error($res, 'Invalid token!', $e->getMessage());
        }

        return false;
    }
}