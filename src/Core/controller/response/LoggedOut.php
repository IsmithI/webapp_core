<?php

namespace Core\controller\response;

class LoggedOut extends AbstractResponse {

	public function getResponseMessage() {
		return [
			"success" => true,
		];
	}
}