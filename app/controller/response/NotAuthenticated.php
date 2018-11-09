<?php

namespace app\controller\response;

use \Klein\Response;

class NotAuthenticated {

	/**
	 *
	 * @var Klein\Response
	 */
	private $response;

	protected function getResponseMessage() {
		return [
			"success" => false,
			"message" => "Not authenticated!"
		];
	}

	public function __construct($response) {
		$this->response = $response;
	}

	public function send() {
		return $this->response->json($this->getResponseMessage());
	}

}