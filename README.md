Mongo Array
===========

An array-like data structure backed by Mongo. Useful for when dealing with very 
large data sets such that the use of an in-memory regular array fails due to 
memory constraints.

You use it like a regular array, it persists values in a Mongo database as if 
by magic.


Usage
-----

### Simple standard array usage

```php
<?php
// Create our Mongo instance, setting it up however you like
$mongo = new \Mongo();

// Create configuration for MongoArray
$configuration = new \webignition\MongoArray\Configuration();
$configuration->initialise('demoDatabase');

// Create a new MongoArray, we'll use this just like a regular array
$mongoArray = new \webignition\MongoArray\MongoArray;
$mongoArray->initialise($mongo, $configuration);

// Let's start from scratch by deleting the (entire!) test Mongo database
$mongoArray->delete(); 

// Add values to the end of the array
$mongoArray[] = 'test item one';
$mongoArray[] = 'test item two'; 

// Values are retained and the size of the array is maintained
$this->assertEquals('test item one', $mongoArray[0]);
$this->assertEquals('test item two', $mongoArray[1]);
$this->assertEquals(2, count($mongoArray));

// Unsetting by index decrements the array size, leaves the  unset
// index containing null
unset($mongoArray[0]);
$this->assertEquals(1, count($mongoArray));
$this->assertNull($mongoArray[0]);

// Add a value back into the first array position
$mongoArray[0] = 'test item one set again';
$this->assertEquals('test item one set again', $mongoArray[0]);
$this->assertEquals(2, count($mongoArray));

// Delete the Mongo database
$mongoArray->delete();  
```