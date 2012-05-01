<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check a previously-set value can be changed
 * 
 */
class UpdateTest extends AbstractMongoArrayTest {

    public function testIfUpdatedValueIsRetained() {        
        $this->mongoArray->delete();
        
        $this->mongoArray[] = 'test item one';
        $this->mongoArray[] = 'test item two';
        $this->mongoArray[] = 'test item three';
        
        $this->assertEquals('test item one', $this->mongoArray[0]);
        $this->assertEquals('test item two', $this->mongoArray[1]);
        $this->assertEquals('test item three', $this->mongoArray[2]);
        
        $this->mongoArray[0] = 'test item one modified';
        $this->mongoArray[1] = 'test item two modified';
        $this->mongoArray[2] = 'test item three modified';
        
        $this->assertEquals('test item one modified', $this->mongoArray[0]);
        $this->assertEquals('test item two modified', $this->mongoArray[1]);
        $this->assertEquals('test item three modified', $this->mongoArray[2]);
    }
    
}