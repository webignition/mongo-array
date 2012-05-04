<?php
ini_set('display_errors', 'On');
ini_set('memory_limit', '10M');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * 
 * Check that we can deal with a MongoArray as if it's a regular
 * array where the array contents exceeeds the amount of memory we have available
 * 
 * Note:
 * One of the main reasons MongoArray was developed was to easily handle
 * arrays containing millions of URLs in situations were the executing host
 * will have nowhere near enough memory to hold all URLs in memory at once
 * 
 */
class LowMemoryTest extends AbstractMongoArrayTest {

    /**
     * Test inserting more than 10 megabytes of data
     * With the memory limit set to 10M, this should result in out of
     * memory errors if using a regular array
     *  
     * Each item inserted is about 1/3 megabytes
     * Inserting 35 should give us at least 10M of data
     * 
     * We're actually inserting 1000 * 32 * 10000 bytes, about 300M of data
     */
    public function testMoreThan10MOfData() {       
        $this->mongoArray->delete();  

        $numberOfItemsToInsert = 1000;
        
        for ($i = 0; $i < $numberOfItemsToInsert; $i++) {
            $this->mongoArray[] = str_repeat('63e3261a00884b74a330199ea70dc1c8', 10000);
        };

        $this->assertEquals($numberOfItemsToInsert, count($this->mongoArray));     
    }   
}