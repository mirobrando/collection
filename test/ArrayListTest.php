<?php

namespace mirolabs\collection\test;

use mirolabs\collection\ArrayList;
use mirolabs\collection\exceptions\InvalidIndexException;
use mirolabs\collection\exceptions\InvalidTypeException;

class ArrayListTest extends \PHPUnit_Framework_TestCase {

    public static $i = [];

    public function testShouldAddItems()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $i = 0;
        $expectedData = ['one', 'two', 'three', 'four', 'five'];
        $this->assertEquals(5, $list->size());
        foreach ($list as $item) {
            $this->assertEquals($expectedData[$i], $item);
            $i++;
        }
    }


    public function testShouldInsertItems()
    {
        $list = new ArrayList('string');
        $list->insert(0, 'one');
        $list->insert(1, 'two');
        $list->insert(2, 'five');
        $list->insert(2, 'three');
        $list->insert(3, 'four');

        $i = 0;
        $expectedData = ['one', 'two', 'three', 'four', 'five'];
        $this->assertEquals(5, $list->size());
        foreach ($list as $item) {
            $this->assertEquals($expectedData[$i], $item);
            $i++;
        }
    }

    public function testShouldInvalidIndexException()
    {
        $list = new ArrayList('string');
        $list->insert(0, 'one');
        $list->insert(1, 'two');

        try {
            $response = $list->insert(4, 'five');
        } catch(InvalidIndexException $e) {
            $response = $e;
        }

        $this->assertInstanceOf('mirolabs\collection\exceptions\InvalidIndexException', $response);
    }

    public function testShouldInvalidTypeException()
    {
        $list = new ArrayList('mirolabs\collection\test\TestType');

        try {
            $response = $list->add('one');
        } catch(InvalidTypeException $e) {
            $response = $e;
        }

        $this->assertInstanceOf('mirolabs\collection\exceptions\InvalidTypeException', $response);
    }


    public function testShouldGetItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $this->assertEquals('one', $list->get(0));
        $this->assertEquals('two', $list->get(1));
        $this->assertEquals('three', $list->get(2));
        $this->assertEquals('four', $list->get(3));
        $this->assertEquals('five', $list->get(4));
    }


    public function testShouldRemoveItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $list->remove(2);

        $this->assertEquals('one', $list->get(0));
        $this->assertEquals('two', $list->get(1));
        $this->assertEquals('four', $list->get(2));
        $this->assertEquals('five', $list->get(3));
    }

    public function testShouldRemoveObject()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $list->removeItem('three');

        $this->assertEquals('one', $list->get(0));
        $this->assertEquals('two', $list->get(1));
        $this->assertEquals('four', $list->get(2));
        $this->assertEquals('five', $list->get(3));
    }


    public function testShouldEachItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        self::$i = [];
        $list->each(function($item) {ArrayListTest::$i[] = $item;});
        var_dump($list);

        $this->assertEquals('one', self::$i[0]);
        $this->assertEquals('two', self::$i[1]);
        $this->assertEquals('three', self::$i[2]);
        $this->assertEquals('four', self::$i[3]);
        $this->assertEquals('five', self::$i[4]);
    }


    public function testShouldFindItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $item = $list->find(function($item) {return $item == 'two';});

        $this->assertEquals('two', $item);
    }

    public function testShouldFilterItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $filterList =  $list->filter(function($item) {return $item != 'two';});

        $this->assertEquals('one', $filterList->get(0));
        $this->assertEquals('three', $filterList->get(1));
        $this->assertEquals('four', $filterList->get(2));
        $this->assertEquals('five', $filterList->get(3));
    }


    public function testShouldMapItem()
    {
        $list = new ArrayList('string');
        $list->add('one');
        $list->add('two');
        $list->add('three');
        $list->add('four');
        $list->add('five');

        $mapList =  $list->map(function($item) {
            $t = new TestType();
            $t->message = $item;
            return $t;
        });

        $this->assertEquals('one', $mapList->get(0)->message);
        $this->assertEquals('two', $mapList->get(1)->message);
        $this->assertEquals('three', $mapList->get(2)->message);
        $this->assertEquals('four', $mapList->get(3)->message);
        $this->assertEquals('five', $mapList->get(4)->message);
    }
}
