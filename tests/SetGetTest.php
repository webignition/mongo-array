<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that items can be written to the array and read back
 * 
 */
class SetGetTest extends AbstractMongoArrayTest {

    public function testReadingWrittenValues() {
        $this->mongoArray->delete();
        
        $numberOfItemsToInsert = rand(0, 100);
        $insertedItems = array();
        
        for ($i = 0; $i < $numberOfItemsToInsert; $i++) {
            $itemToInsert = md5(microtime(true).rand(0, 100));
            
            $insertedItems[] = $itemToInsert;            
            $this->mongoArray[] = $itemToInsert;
        }
        
        for ($i = 0; $i < $numberOfItemsToInsert; $i++) {
            $this->assertEquals($insertedItems[$i], $this->mongoArray[$i]);
        }        
    }
    
}