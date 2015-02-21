<?php

namespace mirolabs\collection;


use mirolabs\collection\exceptions\InvalidIndexException;

class ArrayList extends Collection
{

    /**
     * @param array $items
     * @return ArrayList
     */
    public static function create(array $items)
    {
        $type = 'string';
        $list  = null;
        foreach ($items as $item) {
            if (is_null($list)) {
                $type = gettype($item);
                if ($type == 'object') {
                    $type = get_class($item);
                }
                $list = new ArrayList($type);
            }

            $list->add($item);
        }

        if (is_null($list)) {
            $list = new ArrayList($type);
        }

        return $list;
    }

    /**
     * @param $item
     * @throws exceptions\InvalidTypeException
     */
    public function add($item)
    {
        $this->validType($item);
        $this->data[$this->size()] = $item;
    }

    /**
     * @param $index
     * @param $item
     * @throws InvalidIndexException
     * @throws exceptions\InvalidTypeException
     */
    public function insert($index, $item)
    {
        if((int)$index > $this->size()) {
            throw new InvalidIndexException('too big index');
        }

        $this->validType($item);

        $tempArray = [];
        $offset = 0;

        if((int)$index < $this->size())
        {
            foreach($this->data as $id=>$value)
            {
                if($id == (int)$index)
                {
                    $tempArray[(int)$index] = $item;
                    $offset++;
                }

                $tempArray[$id + $offset] = $value;
            }
            $this->data = $tempArray;
        }
        else
            $this->add($item);
    }

    public function get($index)
    {
        if((int)$index >= $this->size()) {
            throw new InvalidIndexException('index is not exists');
        }

        return $this->data[(int)$index];
    }

    /**
     * @param $index
     * @throws InvalidIndexException
     */
    public function remove($index)
    {
        if((int)$index >= $this->size()) {
            throw new InvalidIndexException('index is not exists');
        }

        $tempArray = [];
        $newIndex = 0;
        foreach($this->data as $key=>$value)
        {
            if ($key == (int)$index) {
                continue;
            }

            $tempArray[$newIndex] = $value;
            $newIndex++;
        }
        $this->data = $tempArray;
    }

    /**
     * @param $item
     * @throws InvalidIndexException
     * @throws exceptions\InvalidTypeException
     */
    public function removeItem($item)
    {
        $this->validType($item);
        $removeKey = null;
        foreach ($this->data as $key => $value) {
            if($value === $item) {
                $removeKey =$key;
                break;
            }
        }

        if (is_null($removeKey)) {
            throw new InvalidIndexException('item not found');
        }

        $this->remove($removeKey);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param callable $callback
     */
    public function each(\Closure $callback)
    {
        foreach ($this->data as $item) {
            $callback($item);
        }
    }

    /**
     * @param callable $condition
     * @return mixed
     */
    public function find(\Closure $condition)
    {
        foreach ($this->data as $item) {
            if ($condition($item)) {
                return $item;
            }

        }
    }

    /**
     * @param callable $condition
     * @return ArrayList
     */
    public function filter(\Closure $condition)
    {
        return self::create(array_filter($this->data, $condition));
    }

    /**
     * @param callable $callback
     * @return ArrayList
     */
    public function map(\Closure $callback)
    {
        return self::create(array_map($callback, $this->data));
    }


}