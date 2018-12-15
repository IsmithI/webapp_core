<?php

use \PHPUnit\Framework\TestCase;
use smith\core\model\Model;

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

}