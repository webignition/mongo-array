<?php

namespace webignition\MongoArray;

class Configuration  {

    
    /**
     * Name of the MongoDB database to use
     * 
     * @var string
     */
    private $databaseName = null;
    
    
    /**
     *
     * @param string $databaseName 
     */
    public function intitialise($databaseName) {
        $this->setDatabaseName($databaseName);
    }
    
    
    /**
     *
     * @param string $databaseName 
     */
    public function setDatabaseName($databaseName) {
        $this->databaseName = $databaseName;
    }
    
    /**
     *
     * @return string
     */
    public function getDatabaseName() {
        return $this->databaseName;
    }
    
}