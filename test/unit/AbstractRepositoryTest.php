<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10.12.18
 * Time: 16:24
 */

use smith\core\repository\AbstractRepository;
use smith\core\collection\Collection;
use \PHPUnit\Framework\TestCase;

class AbstractRepositoryTest extends TestCase
{

    /** @test */
    public function check_repository_query_builder_to_get_data()
    {
        $repository = new AbstractRepository("users");
        $users = $repository->query()
            ->fields(['id', 'deleted'])
            ->where(['deleted' => false])
            ->retrieve();

        $this->assertInstanceOf(Collection::class, $users);
        $this->assertTrue($users->count() > 0);
    }
}
