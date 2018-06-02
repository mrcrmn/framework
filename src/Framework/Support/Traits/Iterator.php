<?php

namespace Framework\Support\Traits;

trait Iterator
{
    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->get(
            $this->position
        );
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return $this->exists($this->position);
    }
}