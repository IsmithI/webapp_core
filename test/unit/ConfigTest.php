<?php

use Core\ConfigReader;

class ConfigTest extends \PHPUnit\Framework\TestCase {

    /** @test */
    public function check_db_config_autoload() {
        $config = ConfigReader::DB_CONFIG_PATH;
        $this->assertEquals("config/database.json", $config);
    }

    /** @test
     * @throws Exception
     */
    public function check_default_router_config() {
        $config = ConfigReader::routes();
        $this->assertEquals([
            "controllers" => "controllers\\",
            "middleware" => "middleware\\",
            "web" => []
        ], $config);
    }
}