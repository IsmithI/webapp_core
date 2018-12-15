<?php

namespace smith\core\controller\response;

abstract class AbstractResponse {

	/**
	 *
	 * @var \Klein\Response
	 */
	protected $response;

	protected abstract function getResponseMessage();

	public function __construct($response) {
		$this->response = $response;
	}

	public function send() {
		return $this->response->json($this->getResponseMessage());
	}

    public function __toString():string {
        return json_encode($this->getResponseMessage());
    }


}