<?php

use Core\repository\CrudRepository;

/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 24.12.18
 * Time: 15:38
 */

class RepositoryTest extends \PHPUnit\Framework\TestCase {


    public function test_relation_loader() {
        $db = \Core\utils\DB::getInstance([
            'database_type' => 'mysql',
            'database_name' => 'upoli',
            'server' => 'localhost',
            'username' => 'root',
            'password' => 'qwer1234',
        ]);

        $usersRepository = new CrudRepository('users');
        $postsRepository = new CrudRepository('posts');

        $users = $usersRepository->query()
                    ->inject($postsRepository)
                    ->retrieve();

        $users->each(function ($user) {
            $this->assertInstanceOf(\Core\collection\Collection::class, $user->posts);
        });

        $this->assertTrue($users->count() > 0);
    }
}