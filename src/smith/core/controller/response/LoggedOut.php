<?php

namespace smith\core\controller\response;

class LoggedOut extends AbstractResponse {

	public function getResponseMessage() {
		return [
			"success" => true,
		];
	}
}