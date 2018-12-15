<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 04.12.18
 * Time: 17:09
 */

namespace smith\core\controller\response;


class Success extends AbstractResponse {

    private $data = [];

    /**
     * Success constructor.
     * @param $data
     */
    public function __construct($resposne, $data) {
        parent::__construct($resposne);

        $this->data = $data;
    }


    protected function getResponseMessage() {
        return [
            "success" => true,
            "data" => $this->data
        ];
    }
}