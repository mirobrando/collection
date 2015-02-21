<?php

namespace mirolabs\collection\exceptions;


use Exception;

class InvalidTypeException extends \Exception
{

    /**
     * @param string $type
     * @param mixed $item
     */
    public function __construct($type,  $item)
    {
        $message = sprintf("Item: %s isn't instnace of %s", $this->getType($item), $type);
        parent::__construct($message, 0, null);
    }

    private function getType($item)
    {
        if (gettype($item) == 'object') {
            return get_class($item);
        }

        return gettype($item);
    }

}