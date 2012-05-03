<?php

namespace webignition\MongoArray;

class MongoArray implements \ArrayAccess, \Countable {
    
    const ITEMS_COLLECTION_NAME = 'items';
    const ITEMS_OBJECT_NAME = 'a';
    const ITEMS_LENGTH_NAME = 'length';
       
    /**
     *
     * @var \webignition\MongoArray\Configuration
     */
    private $configuration = null;    
    
    /**
     *
     * @var \Mongo
     */
    private $mongo = null;
    
    
    /**
     *
     * @var \MongoDB
     */
    private $mongoDB = null;
    
    
    /**
     *
     * @var \MongoCollection
     */
    private $itemsCollection = null;    
    
    /**
     * Initialise this MongoArray, passing in your Mongo object that has been 
     * set up as required
     * 
     * @param \Mongo $mongo 
     */
    public function initialise(\Mongo $mongo, \webignition\MongoArray\Configuration $configuration) {
        $this->mongo = $mongo;
        $this->configuration = $configuration;
    }
    
    
    /**
     * Whether or not an offset exists.
     * 
     * This method is executed when using isset() or empty() on objects implementing ArrayAccess.
     * 
     * @param int $offset
     * @return boolean 
     * @see http://www.php.net/manual/en/arrayaccess.offsetexists.php
     */
    public function offsetExists($offset) {        
        if (is_null($offset)) {
            return false;
        }
        
        $result = $this->itemsCollection()->findOne(array(), array(
            self::ITEMS_OBJECT_NAME => array(
                '$slice' => array($offset, 1)
            )
        ));
        
        if (is_null($result)) {
            return false;
        }
        
        return count($result[self::ITEMS_OBJECT_NAME]) > 0;
    }

    
    /**
     * Returns the value at specified offset.
     * 
     * This method is executed when checking if offset is empty().
     * 
     * @param int $offset 
     * @return mixed
     * @see http://www.php.net/manual/en/arrayaccess.offsetget.php
     */
    public function offsetGet($offset) {        
        if (!$this->offsetExists($offset)) {
            return null;
        }
        
        $result = $this->itemsCollection()->findOne(array(), array(
            self::ITEMS_OBJECT_NAME => array(
                '$slice' => array($offset, 1)
            )
        ));
        
        return $result[self::ITEMS_OBJECT_NAME][0];
    }   
    
    
    public function delete() {
        $this->mongoDB()->drop();
    }
    

    /**
     * Assigns a value to the specified offset.
     * 
     * @param mixed $offset
     * @param mixed $value 
     * @see http://www.php.net/manual/en/arrayaccess.offsetset.php
     */
    public function offsetSet($offset, $value) {          
        if (is_null($offset)) {
            $this->insert($value);
            $this->incrementLength();
        } else {
            if (is_null($this->offsetGet($offset))) {
                $this->incrementLength();
            }

            $this->update($offset, $value);              
        }
    }
    
    
    /**
     * Shift an element off the beginning of array
     * 
     * Identical in functionalty to array_shift()
     * @see http://php.net/manual/en/function.array-shift.php
     * 
     * @return mixed
     */
    public function shift() {        
        $item = $this->offsetGet(0);
        
        $this->itemsCollection()->update(array(), array('$pop' => array(
            self::ITEMS_OBJECT_NAME => -1
        )));
        
        $this->decrementLength();
        
        return $item;
    }

    
    /**
     * Unsets an offset.
     * This method will not be called when type-casting to (unset)
     * 
     * Note: this leaves a NULL value at the unset offset. This ensures
     * the array index behaviour matches that off PHP's internal array.
     * 
     * @param mixed $offset 
     */
    public function offsetUnset($offset) {                
        $this->itemsCollection()->update(array(), array('$unset' => array(
            self::ITEMS_OBJECT_NAME.'.'.$offset => 1
        )));   
        
        $this->decrementLength();
    }
    
    private function incrementLength() {
        $this->itemsCollection()->update(array(), array('$inc' => array(
            self::ITEMS_LENGTH_NAME => 1
        )        
        ));     
    }
    
    private function decrementLength() {
        if ($this->count() > 0) {
            $this->itemsCollection()->update(array(), array('$inc' => array(
                self::ITEMS_LENGTH_NAME => -1
            )        
            ));            
        }     
    }   
    
    
    /**
     *
     * @param mixed $value
     * @return boolean 
     */
    public function contains($value) {        
        return $this->itemsCollection()->find(array(
            self::ITEMS_OBJECT_NAME => $value
        ))->limit(1)->count() > 0;
    }
    
    
    /**
     *
     * @param mixed $value 
     */
    private function insert($value) {
        $this->itemsCollection()->update(array(), array('$push' => array(
            self::ITEMS_OBJECT_NAME => $value
        )));      
    }
    
    
    /**
     *
     * @param int $offset
     * @param mixed $value 
     */
    private function update($offset, $value) {        
        $this->itemsCollection()->update(array(), array('$set' => array(
            self::ITEMS_OBJECT_NAME.'.'.$offset => $value
        )));
    }
    
    
    /**
     *
     * @return int
     */
    public function count() {        
        if (!$this->hasItemsCollection()) {
            $this->initialiseItems();
        }
        
        $lengthResult = $this->itemsCollection()->findOne(array(), array(
            self::ITEMS_LENGTH_NAME
        ));
        
        return $lengthResult[self::ITEMS_LENGTH_NAME];      
    }
    
    
    /**
     *
     * @return \MongoCollection
     */
    public function itemsCollection() {        
        if (is_null($this->itemsCollection)) {
            $this->itemsCollection = $this->mongoDB()->selectCollection(self::ITEMS_COLLECTION_NAME);
            
            if ($this->itemsCollection->count() == 0) {                
                $this->itemsCollection->insert(array(
                    self::ITEMS_LENGTH_NAME => 0,
                    self::ITEMS_OBJECT_NAME => array()             
                ));                
            }         
        }
        
        return $this->itemsCollection;
    }
    
    /**
     *
     * @return boolean
     */
    private function hasItemsCollection() {
        return $this->itemsCollection()->count() > 0;
    }
    
    
    /**
     *
     * @return \MongoDB
     */
    private function mongoDB() {
        if (is_null($this->mongoDB)) {
            $this->mongoDB = $this->mongo->selectDB($this->configuration->getDatabaseName());
        }
        
        return $this->mongoDB;
    }
    
}