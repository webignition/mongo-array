<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that we can add and then count large numbers of items
 */
class LargeCountTest extends AbstractMongoArrayTest {

    public function testCountOneHundred() {
        $this->itemSetCount(100);
    }
    
    public function testCountOneThousand() {
        $this->itemSetCount(1000);
    }
    
    public function testCountTenThousand() {
        $this->itemSetCount(10000);
    }   
    
    private function itemSetCount($numberOfItemsToInsert) {
        $this->mongoArray->delete();  

        for ($i = 0; $i < $numberOfItemsToInsert; $i++) {
            $this->mongoArray[] = '63e3261a00884b74a330199ea70dc1c8';
        };

        $this->assertEquals($numberOfItemsToInsert, count($this->mongoArray));        
    }    
}