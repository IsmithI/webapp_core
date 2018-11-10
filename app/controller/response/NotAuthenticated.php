<?php

namespace app\controller\response;

class NotAuthenticated extends AbstractResponse {

	protected function getResponseMessage() {
		return [
			"success" => false,
			"message" => "Not authenticated!"
		];
	}

}