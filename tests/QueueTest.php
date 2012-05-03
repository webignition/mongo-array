<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that values can be queued up and shifted out in order
 * 
 */
class QueueTest extends AbstractMongoArrayTest {

    const TEST_ITEM_COUNT = 50;
    
    public function testQueue() {        
        $this->mongoArray->delete();
        
        for ($testItem = 0; $testItem < self::TEST_ITEM_COUNT; $testItem++) {
            $this->mongoArray[] = $testItem;
        }
        
        for ($testItemVerification = 0; $testItemVerification < self::TEST_ITEM_COUNT; $testItemVerification++) {
            $this->assertEquals($testItemVerification, $this->mongoArray->shift());
        }        
    }   
}