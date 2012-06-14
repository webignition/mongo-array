<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that the contents of a mongo array can be iterated over
 * 
 */
class IteratorTest extends AbstractMongoArrayTest {

    public function testIteratingOverContents() {
        $this->mongoArray->delete();
        
        $testValues = array(
            'test value 1',
            'test value 2',
            'test value 3'
        );
        
        foreach ($testValues as $testValue) {
            $this->mongoArray[] = $testValue;
        }

        $expectedCurrentKey = 0;
        
        foreach ($this->mongoArray as $key => $value) {
            $this->assertEquals($expectedCurrentKey, $key);
            $this->assertEquals($testValues[$expectedCurrentKey], $value);
            
            $expectedCurrentKey++;
        }
    }
    
}