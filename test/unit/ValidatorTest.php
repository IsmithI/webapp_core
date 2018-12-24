<?php


use Core\model\Model;
use Core\validator\Validator;

/**
 * Created by IntelliJ IDEA.
 * User: smith
 * Date: 23.12.18
 * Time: 23:17
 */

class ValidatorTest extends \PHPUnit\Framework\TestCase {


    /** @test */
    public function test_builder_creation_process() {
        $user = new Model([
            "first_name" => "Oleg",
            "email" => "asdsad",
            "age" => -2,
            "friends" => null
        ]);

        $validator = new Validator($user);

        $isValid = $validator
            ->isString('first_name')
                ->lengthIsBetween(0, 16)
                ->and()

            ->isEmail('email')

            ->isNumber('age')
                ->isPositive()
                ->inRange(0, 100)
                ->and()

            ->isNotNull('friends')

            ->validate();

        $this->assertTrue(!$isValid);

        $user = new Model([
            "first_name" => "Oleg",
            "email" => "asdsad@mail.com",
            "age" => 20,
            "friends" => ["Antonio", "Alex", "Denis Vult"]
        ]);

        $validator->setModel($user);
        $isValid = $validator->validate();

        $this->assertTrue($isValid);
    }
}