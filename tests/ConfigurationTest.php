<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');


class ConfigurationTest extends AbstractMongoArrayTest {

    public function testDatabaseName() {
        $this->assertInstanceOf('\webignition\MongoArray\Configuration', $this->configuration);
        $this->assertEquals(self::CONFIGURATION_DATABASE_NAME, $this->configuration->getDatabaseName());
    } 
    
}