<?php

namespace app\model;

class Users extends DBModel {

	public function nonAttributes() {
		return ['id', 'role'];
	}
}