<?php
ini_set('display_errors', 'On');
require_once(__DIR__.'/../lib/bootstrap.php');

/**
 * Check that data stored in a MongoArray is persisted
 */
class PersistenceTest extends AbstractMongoArrayTest {
    
    const TEST_ITEM_COUNT = 100;

    public function testPopulateMongoArray() {
        $this->mongoArray->delete();
        
        for ($i = 0; $i < self::TEST_ITEM_COUNT; $i++) {
            $this->mongoArray[] = $this->getTestItem($i);
        }
    }    
    
    public function testReadBackFromMongoArray() {
        for ($i = 0; $i < self::TEST_ITEM_COUNT; $i++) {
            $this->assertEquals($this->getTestItem($i), $this->mongoArray[$i]);
        }
        
        $this->mongoArray->delete();
    }
    
    
    /**
     *
     * @param int $testItemIndex
     * @return string
     */
    private function getTestItem($testItemIndex) {
        return 'test item ' . $testItemIndex;
    }
    
}