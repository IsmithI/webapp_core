<?php

namespace app\model;

class Users extends DBModel {

	public static function nonAttributes() {
		return ['id', 'deleted', 'role'];
	}
}