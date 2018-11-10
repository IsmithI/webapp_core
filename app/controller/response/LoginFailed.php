<?php

namespace app\controller\response;

class LoginFailed extends AbstractResponse {

	protected function getResonseMessage() {
		return [
			"success" => false,
			"message" => "Authentication failed!"
		];
	}
}