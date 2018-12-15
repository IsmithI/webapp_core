<?php

class ConfigTest extends \PHPUnit\Framework\TestCase {

    /** @test */
    public function check_db_config_autoload() {
        $config = \Core\ConfigReader::DB_CONFIG_PATH;
        $this->assertEquals("config/database.json", $config);
    }
}