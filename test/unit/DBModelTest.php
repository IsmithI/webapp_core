<?php

use \PHPUnit\Framework\TestCase;
use \app\collection\Collection;
use \app\model\DBModel;
use \app\model\Model;
use \app\utils\DB;

class DBModelTest extends TestCase {

	/** @test */
	public function db_model_returns_table_name_based_on_its_class_name() {
		$this->assertEquals(DBModel::table(), "dbmodel");
	}

	/** @test */	
	public function check_that_we_return_collection_of_models_by_params_and_not_just_plain_array() {
		$models = DBModel::all(['id' => 1]);

		$this->assertInstanceOf(Collection::class, $models);
	}


	/** @test */
	public function db_model_can_be_saved_to_db_modified_and_then_deleted_from_db() {
		$model = new DBModel([
			"first_name" => "Oleg",
			"last_name" => "Bondar"
		]);

		$id = $model->save();
		$this->assertTrue($id > 0);

		$model->first_name = "Changed";
		$model->save();

		$model = DBModel::one(['id' => $model->id]);
		$this->assertEquals($model->first_name, "Changed");

		$model->delete();
		$this->assertTrue(!DBModel::one(['id' => $model->id]));
		
	}

	/** @test */
	public function check_that_record_exists_and_does_not_exists_in_db() {
		$model = new DBModel(['id' => 1, 'created' => "123123"]);
		$id = $model->save();

		$this->assertTrue($model->exists());

		$model->id = 9999;
		$this->assertTrue(!$model->exists());

		$model = new DBModel();
		$this->assertTrue(!$model->exists());		
	}
	
	public function check_that_we_can_get_only_one_record_by_search_params() {
		$model = DBModel::one(['id' => 1]);

		$this->assertInstanceOf(Model::class, $model);
		$this->assertEquals($model->id, 1);
	}

}