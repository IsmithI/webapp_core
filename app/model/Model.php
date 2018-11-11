<?php

namespace app\model;

class Model {

	public function __construct(array $attributes = []) {
		foreach ($attributes as $key => $value) $this->$key = $value;
	}

	public function __set(string $name, $value) {
		$this->$name = $value;
	}

	public function __get(string $name) {
		return $this->$name;
	}

	public function has(string $name) {
		return isset($this->$name);
	}
	
	public function toJson() {
		return json_encode(get_object_vars($this));
	}

	public function toArray() {
		return get_object_vars($this);
	}
}