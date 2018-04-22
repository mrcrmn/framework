<?php

namespace Framework\Session;

use Exception;

class SessionBag
{
    /**
     * Checks if the array key exists.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key)
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Returns the array.
     *
     * @return array
     */
    public function all()
    {
        return $_SESSION;
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
        return $this->has($key) ? $_SESSION[$key] : $default;
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

        return $_SESSION[$key] = $value;
    }

    /**
     * Removes a parameter by key.
     *
     * @param string $key
     * @return void
     */
    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Returns the array keys.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($_SESSION);
    }

    /**
     * Returns the array values.
     *
     * @return array
     */
    public function values()
    {
        return array_values($_SESSION);
    }
}
