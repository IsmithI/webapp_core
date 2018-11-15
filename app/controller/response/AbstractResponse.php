<?php

namespace app\controller\response;

abstract class AbstractResponse {

	/**
	 *
	 * @var Klein\Response
	 */
	protected $response;

	protected abstract function getResponseMessage();

	public function __construct($response) {
		$this->response = $response;
	}

	public function send() {
		return $this->response->json($this->getResponseMessage());
	}
}