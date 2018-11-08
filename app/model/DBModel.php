<?php

namespace app\model;

use \app\collection\Collection;
use \app\utils\DB;

class DBModel extends Model {

	public static function nonAttributes() {
		return ['id', 'deleted'];
	}

	public static function table() {
		return \strtolower((new \ReflectionClass(get_called_class()))->getShortName());
	}

	public static function all(array $params = []) {
		$db = DB::getInstance();
		
		$rawData = $db->select(self::table(), ['id[Int]', 'deleted[Bool]', 'attributes[JSON]'], $params);
		
		$className = \get_called_class();
		$models = new Collection();
		foreach ($rawData as $data) {
			$model = new $className();
			$model->id = $data["id"];
			$model->deleted = $data["deleted"];

			foreach ($data["attributes"] as $key => $value) $model->$key = $value;

			$models->push($model);
		}

		return $models;
	}

	public static function one(array $params) {
		$db = DB::getInstance();

		$rawData = $db->get(self::table(), ['id[Int]', 'deleted[Bool]', 'attributes[JSON]'], $params);
		if (!$rawData) return false;

		$className = \get_called_class();		
		$model = new $className([
			"id" => $rawData["id"],
			"deleted" => $rawData["deleted"]
		]);
		foreach ($rawData["attributes"] as $key => $value) $model->$key = $value;

		return $model;
	}

	public function save() {
		$nonAttributes = self::nonAttributes();

		$data = [];
		foreach ($this as $key => $value)
			if (!in_array($key, $nonAttributes)) $data[$key] = $value;

		$db = DB::getInstance();			

		if ($this->exists())
			$db->update(self::table(), ['attributes' => json_encode($data)], ['id' => $this->id]);
		else {
			$db->insert(self::table(), ['attributes' => json_encode($data), 'deleted' => 0]);
			$this->deleted = 0;
			$this->id = $db->id();
		}

		return $this->id;
	}

	public function exists() {
		if (!isset($this->id)) return false;

		$db = DB::getInstance();

		return $db->has(self::table(), ['id' => $this->id]);
	}

	public function delete() {
		if (!isset($this->id)) return false;

		$db = DB::getInstance();
		$db->delete(self::table(), ['id' => $this->id]);
	}
}