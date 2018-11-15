<?php

namespace app\model;

class Users extends Model {

	public function getFullName() {
		return $this->first_name . " " . $this->last_name;
	}

	public static function getFormat(): Model {
	    return new Model([
	        "id" => "int",
            "deleted" => "bool",
            "attributes" => "json"
        ]);
    }
}