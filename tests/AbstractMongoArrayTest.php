<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

abstract class AbstractMongoArrayTest extends PHPUnit_Framework_TestCase {
    
    const CONFIGURATION_DATABASE_NAME = 'testDatabase';
    
    /**
     *
     * @var  \Mongo
     */
    protected $mongo = null;
    
    
    /**
     *
     * @var \webignition\MongoArray\MongoArray
     */
    protected $mongoArray = null;
    
    
    /**
     *
     * @var \webignition\MongoArray\Configuration
     */
    protected $configuration = null;    

    protected function setUp() {        
        $this->configuration = new \webignition\MongoArray\Configuration();
        $this->configuration->intitialise(self::CONFIGURATION_DATABASE_NAME);        

        $this->mongo = new \Mongo();

        $this->mongoArray = new \webignition\MongoArray\MongoArray;
        $this->mongoArray->intitialise($this->mongo, $this->configuration);
    }    
    
    protected function tearDown() {
    }
}