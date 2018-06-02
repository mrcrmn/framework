<?php

namespace Framework\Support\Traits;

trait ArrayAccess
{
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    public function offsetSet($key, $value)
    {
        if (is_null($key)) {
            $this->set($value);
        } else {
            $this->set($key, $value);
        }
    }

    public function offsetExists($key)
    {
        return $this->exists($key);
    }

    public function offsetUnset($key)
    {
        $this->unset($key);
    }

}