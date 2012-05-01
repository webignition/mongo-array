<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that unset() removes an item from the array
 * 
 */
class UnsetTest extends AbstractMongoArrayTest {

    public function testUnsettingFirstItemRemovesItAndShiftsUpRemainingItems() {        
        $this->mongoArray->delete();
        
        $this->mongoArray[] = 'test item one';
        $this->mongoArray[] = 'test item two';
        $this->mongoArray[] = 'test item three';
        $this->assertEquals('test item one', $this->mongoArray[0]);
        $this->assertEquals('test item two', $this->mongoArray[1]);
        $this->assertEquals('test item three', $this->mongoArray[2]);
        
        $this->assertEquals(3, count($this->mongoArray));
        
        unset($this->mongoArray[0]);

        $this->assertNull($this->mongoArray[0]);
        $this->assertEquals('test item two', $this->mongoArray[1]);
        $this->assertEquals('test item three', $this->mongoArray[2]);                
        
        $this->assertEquals(2, count($this->mongoArray));
    }
    
}