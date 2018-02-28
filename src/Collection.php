<?php

namespace mirolabs\collection;


use mirolabs\collection\exceptions\InvalidTypeException;

abstract class Collection implements \Iterator
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected $type;

    /**
     * @var int
     */
    protected $currentIndex = 0;


    /**
     * @param string $type type of list items
     */
    public function __construct($type)
    {
        $this->type = $type;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        return $this->data[$this->currentIndex];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        if ($this->valid()) {
            $this->currentIndex++;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->currentIndex;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->currentIndex < $this->size();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /**
     * @return int size of list
     */
    public final function size()
    {
        return count($this->data);
    }

    /**
     * clear list
     */
    public final function clear()
    {
        $this->data = [];
        $this->currentIndex = 0;
    }

    /**
     * @param $item
     * @throws InvalidTypeException
     */
    protected function validType($item)
    {
        if (gettype($item) == 'object') {
            if (!$item instanceof $this->type) {
                throw new InvalidTypeException($this->type, $item);
            }
        } else {
            if (gettype($item) != $this->type) {
                throw new InvalidTypeException($this->type, $item);
            }
        }
    }

}
