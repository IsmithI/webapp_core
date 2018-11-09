<?php

namespace app\model;

class Users extends DBModel {

	public static function nonAttributes() {
		return ['id', 'deleted', 'role'];
	}

	public function getFullName() {
		return $this->first_name . " " . $this->last_name;
	}
}