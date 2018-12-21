<?php

namespace Core\model;

class Users extends Model {

	public function getFullName() {
		return $this->attributes["first_name"] . " " . $this->attributes["last_name"];
	}

	public static function getFormat(): Model {
	    return new Model([
	        "class" => Users::class,
	        "id" => "int",
            "deleted" => "bool",
            "attributes" => new Model()
        ]);
    }
}