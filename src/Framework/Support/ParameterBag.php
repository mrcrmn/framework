<?php

namespace Framework\Support;

use Exception;

class ParameterBag
{
    /**
     * The array of this parameter bag.
     *
     * @var array
     */
    protected $array = array();

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * Checks if the array key exists.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $this->array);
    }

    /**
     * Returns the array.
     *
     * @return array
     */
    public function all()
    {
        return $this->array;
    }

    /**
     * Gets an array entry by key and returns a default if it doesn't exist.
     *
     * @param string $key
     * @param mixed $default
     * 
     * @return void
     */
    public function get($key, $default = false)
    {
        return $this->has($key) ? $this->array[$key] : $default;
    }

    /**
     * Adds a parameter to the array.
     *
     * @param string $key
     * @param mixed $value
     * 
     * @return void
     */
    public function add($key, $value)
    {
        if ($this->has($key)) {
            throw new Exception("Key {$key} already exists.");
        }

        return $this->array[$key] = $value;
    }

    /**
     * Removes a parameter by key.
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        $this->array[$key] = null;
    }
}
