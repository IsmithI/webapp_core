<?php

namespace Core\controller\response;

class LoginFailed extends AbstractResponse {

	protected function getResponseMessage() {
		return [
			"success" => false,
			"message" => "Authentication failed!"
		];
	}
}