<?php

use \PHPUnit\Framework\TestCase;
use Core\model\Model;

class ModelTest extends TestCase {

	/** @test */
	public function model_can_set_and_get_values() {
		$model = new Model();

		$model->firstName = "Oleg";

		$this->assertEquals($model->firstName, "Oleg");
	}

	/** @test */
	public function model_can_be_initialized_with_array_as_constructor_argument() {
		$model = new Model([
			'first_name' => 'Oleg'
		]);

		$this->assertEquals($model->first_name, 'Oleg');
	}

	/** @test */
	public function model_can_return_its_data_in_json_format() {
		$model = new Model([
			'first_name' => 'Oleg',
			'last_name' => 'Bondar',
			'activities' => ['Coding', 'Board Games']
		]);
		$model->age = 20;

		$this->assertEquals('{"first_name":"Oleg","last_name":"Bondar","activities":["Coding","Board Games"],"age":20}', $model->toJson());
	}

	/** @test */
	public function model_is_iterable() {
		$model = new Model([
			'first_name' => 'Oleg',
			'last_name' => 'Bondar'
		]);

		$newArray = [];
		foreach($model as $key => $val) $newArray[$key] = $val;

		$this->assertEquals($newArray['first_name'], $model->first_name);
		$this->assertEquals($newArray['last_name'], $model->last_name);
	}

	/** @test */
	public function model_can_be_formatted_to_given_format() {
	    $model = new Model([
	        "id" => "2",
            "deleted" => 0,
            "attributes" => [
                "first_name" => "Oleg",
                "last_name" => "Bondar"
            ]
        ]);

	    $format = new Model([
	        "class" => SampleClass::class,
	        "id" => "int",
            "deleted" => "bool",
            "attributes" => new Model()
        ]);

	    $user = $model->format($format);

	    $this->assertInstanceOf(SampleClass::class, $user);
	    $this->assertInstanceOf(Model::class, $user->attributes);
	    $this->assertEquals($user->id, 2);
    }
}

class SampleClass extends Model {}