<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that MongoArray->count() reflects the same number of items added
 */
class CountTest extends AbstractMongoArrayTest {

    public function testCountOfInsertedItems() {
        $this->mongoArray->delete();
        
        $numberOfItemsToInsert = rand(0, 100);
        
        for ($i = 0; $i < $numberOfItemsToInsert; $i++) {
            $this->mongoArray[] = md5(microtime(true).rand(0, 100));
        }
        
        $this->assertEquals($numberOfItemsToInsert, $this->mongoArray->count());
    }    
}