<?php

namespace Framework\Support;

use Iterator;
use Countable;
use ArrayAccess;
use JsonSerializable;
use Framework\Support\Traits\Iterator as IteratorTrait;
use Framework\Support\Traits\ArrayAccess as ArrayAccessTrait;
use Framework\Support\Traits\JsonSerializeable as JsonSerializableTrait;

class Arr implements ArrayAccess, Countable, Iterator, JsonSerializable
{
    use ArrayAccessTrait, IteratorTrait, JsonSerializableTrait;

    /**
     * The main array.
     *
     * @var array
     */
    protected $array = array();

    /**
     * The current position of the iterator.
     *
     * @var int
     */
    protected $position;

    /**
     * The constructer for the array.
     *
     * @param array $array
     */
    public function __construct($array = array())
    {
        $this->array = is_array($array) ? $array : func_get_args();
        $this->position = 0;
    }

    /**
     * Static call to create a new array instance.
     *
     * @param array $array
     * @return self
     */
    public static function make($array = array())
    {
        return new self(is_array($array) ? $array : func_get_args());
    }

    /**
     * Gets a value by key
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Sets an array key and value.
     *
     * @param int|string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Converts the array to a string using ',' as a seperator.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->implode(', ');
    }

    /**
     * Sets the given attribute as a value for the key, that is the method.
     *
     * @return void
     */
    public function __call($key, $arguments)
    {
        if (empty($arguments)) {
            return $this->get($key);
        }

        $this->set($key, $arguments[0]);
    }

    /**
     * Dumps the array.
     *
     * @return self
     */
    public function dump()
    {
        return dump($this->array);
    }

    /**
     * Dumps the array and then dies.
     *
     * @return self
     */
    public function dd()
    {
        return dd($this->array);
    }

    /**
     * Gets an element of the array by key.
     *
     * @param int|string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->exists($key) ? $this->array[$key] : null;
    }

    /**
     * Adds an element to the array. With key or without.
     *
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value = null)
    {
        if (isset($value)) {
            return $this->array[$key] = $value;
        }

        return $this->array[] = $key;
    }

    /**
     * Unsets an element of the array by a given key.
     *
     * @param string $key
     * @return $this
     */
    public function unset($key)
    {
        unset($this->array[$key]);

        return $this;
    }

    /**
     * Returns the array as a json.
     *
     * @return string
     */
    public function json()
    {
        return json_encode($this->array);
    }

    /**
     * Returns the length of the array.
     *
     * @return int
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * Reverses the array.
     *
     * @return $this
     */
    public function reverse($preserve = false)
    {
        $this->array = array_reverse($this->array, $preserve);

        return $this;
    }

    /**
     * Checks if a given key exists.
     *
     * @param int|string $key
     * @return bool
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->array) && isset($this->array[$key]);
    }

    /**
     * Calls the given function on each element of the array.
     *
     * @param Callable $callback
     * @return self
     */
    public function map($callback)
    {
        return new self(
            array_map($callback, $this->array)
        );
    }

    /**
     * Runs the given callback on each element of the array.
     *
     * @param Callable $callback
     * @return $this
     */
    public function each($callback)
    {
        foreach ($this->array as $key => $value) {
            is_int($key) ? $callback($value) : $callback($key, $value);
        }

        return $this;
    }

    /**
     * Returns the sum of all array elements.
     *
     * @return number
     */
    public function sum()
    {
        return array_sum($this->array);
    }

    /**
     * Searches the array by a given needle and returns the key.
     *
     * @param mixed $needle
     * @return int|string
     */
    public function search($needle)
    {
        return array_search($needle, $this->array);
    }

    /**
     * Filters the array by a given callback.
     *
     * @param Callable $callback
     * @return self
     */
    public function filter($callback = null)
    {
       $this->array = array_filter($this->array, $callback);

       return $this;
    }

    /**
     * Splits the array into chunks of the given size.
     *
     * @param string $size
     * @return self
     */
    public function chunk($size)
    {
        $chunked = array_chunk($this->array, $size);
        $this->array = array_map(function($item) {
            return new self($item);
        }, $chunked);

        return $this;
    }

    /**
     * Slices the array.
     *
     * @param int $offset
     * @param int $length
     * @param bool $preserveKeys
     * @return $this
     */
    public function slice($offset = 0, $length = 1, $preserveKeys = false)
    {
        $this->array = array_slice($this->array, $offset, $length, $preserveKeys);

        return $this;
    }

    /**
     * Implodes the array using the given parameter as glue.
     *
     * @param string $glue
     * @return string
     */
    public function implode($glue)
    {
        return implode($glue, $this->array);
    }

    /**
     * Explodes a string and returns a new array instance.
     *
     * @param string $delimiter
     * @param string $string
     * @return self
     */
    public static function explode($delimiter, $string)
    {
        return new self(
            explode($delimiter, $string)
        );
    }

    /**
     * Returns the keys of the array.
     *
     * @return self
     */
    public function keys()
    {
        return new self(
            array_keys($this->array)
        );
    }

    /**
     * Returns the values of the array.
     *
     * @return self
     */
    public function values()
    {
        return new self(
            array_values($this->array)
        );
    }

    /**
     * Removes the last element of the array and returns it.
     *
     * @return mixed
     */
    public function pop()
    {
        return array_pop($this->array);
    }

    /**
     * Removes the first element of the array and returns it.
     *
     * @return mixed
     */
    public function shift()
    {
        return array_shift($this->array);
    }

    /**
     * Checks if the given value is in the array.
     *
     * @param mixed $needle
     * @return bool
     */
    public function in($needle)
    {
        return in_array($needle, $this->array);
    }

    /**
     * Sorts the array in ascending order.
     *
     * @return $this
     */
    public function sort()
    {
        sort($this->array);

        return $this;
    }

    /**
     * Sorts the array in descending order.
     *
     * @return $this
     */
    public function sortDesc()
    {
        rsort($this->array);

        return $this;
    }

    /**
     * Sorts the array by a given function.
     *
     * @param Callable $callback
     * @return $this
     */
    public function sortByFunc($callback)
    {
        uasort($this->array, $callback);

        return $this;
    }
}
