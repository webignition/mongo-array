<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that values can be shifted from the array
 * 
 */
class ShiftTest extends AbstractMongoArrayTest {

    public function testShift() {        
        $this->mongoArray->delete();
        
        $this->mongoArray[] = 'test item one';
        $this->mongoArray[] = 'test item two';
        $this->mongoArray[] = 'test item three';
        
        $this->assertEquals('test item one', $this->mongoArray[0]);
        $this->assertEquals('test item two', $this->mongoArray[1]);
        $this->assertEquals('test item three', $this->mongoArray[2]);       
        $this->assertEquals(3, count($this->mongoArray));
        
        $firstItem = $this->mongoArray->shift();
        
        $this->assertEquals('test item one', $firstItem);
        $this->assertEquals('test item two', $this->mongoArray[0]);
        $this->assertEquals('test item three', $this->mongoArray[1]);
        $this->assertEquals(2, count($this->mongoArray));
        
        $secondItem = $this->mongoArray->shift();
        
        $this->assertEquals('test item one', $firstItem);
        $this->assertEquals('test item two', $secondItem);
        $this->assertEquals('test item three', $this->mongoArray[0]);        
        $this->assertEquals(1, count($this->mongoArray));
        
        $thirdItem = $this->mongoArray->shift();
        
        $this->assertEquals('test item one', $firstItem);
        $this->assertEquals('test item two', $secondItem);
        $this->assertEquals('test item three', $thirdItem);        
        $this->assertEquals(0, count($this->mongoArray));
        
        $fourthItem = $this->mongoArray->shift();
        $this->assertEquals(0, count($this->mongoArray));
        
    }   
}