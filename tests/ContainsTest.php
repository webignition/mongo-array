<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that unset() removes an item from the array
 * 
 */
class ContainsTest extends AbstractMongoArrayTest {

    public function testIfValueExistsInArray() {        
        $this->mongoArray->delete();
        
        $this->mongoArray[] = 'test item one';
        $this->mongoArray[] = 'test item two';
        $this->mongoArray[] = 'test item three';
        
        $this->assertTrue($this->mongoArray->contains('test item one'));
        $this->assertTrue($this->mongoArray->contains('test item two'));
        $this->assertTrue($this->mongoArray->contains('test item three'));
        $this->assertFalse($this->mongoArray->contains('value not present'));
    }
    
}