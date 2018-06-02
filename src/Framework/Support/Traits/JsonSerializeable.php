<?php

namespace Framework\Support\Traits;

trait JsonSerializeable
{
    public function jsonSerialize()
    {
        return $this->json();
    }
}