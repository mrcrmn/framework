<?php

namespace Framework\Support;

use ArrayAccess;
use Framework\Support\Traits\ArrayAccessible;

class Arr implements ArrayAccess
{
    use ArrayAccessible;

    /**
     * The main array.
     *
     * @var array
     */
    protected $array = array();

    /**
     * The constructer for the array.
     *
     * @param array $array
     */
    public function __construct($array = array())
    {
        $this->array = is_array($array) ? $array : func_get_args();
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
        $this->add($key, $value);
    }

    /**
     * Gets an element of the array by key.
     *
     * @param int|string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->array[$key];
    }

    /**
     * Adds an element to the array. With key or without.
     *
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function add($key, $value = null)
    {
        if (isset($value)) {
            return $this->array[$key] = $value;
        }

        return $this->array[] = $key;
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
     * @param callable $callback
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
     * @param callable $callback
     * @return void
     */
    public function each($callback)
    {
        foreach ($this->array as $key => $value) {
            $callback($key, $value);
        }
    }

    /**
     * Implodes the array, using the given parameter as glue.
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
}
