<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 06.12.18
 * Time: 19:50
 */

namespace smith\core\controller\response;


class Error extends AbstractResponse {

    private $type, $message;

    /**
     * Error constructor.
     * @param $type
     * @param $message
     */
    public function __construct($res, $message, $type = 'error') {
        parent::__construct($res);

        $this->type = $type;
        $this->message = $message;
    }


    protected function getResponseMessage() {
        return [
            "success" => false,
            "type" => $this->type,
            "message" => $this->message
        ];
    }
}