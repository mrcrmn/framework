<?php

namespace Framework\Database;

use Framework\Support\ParameterBag;
use Framework\Support\Arr;

abstract class Model
{
    public $attributes = array();
    protected $builder;

    abstract public function getTable();

    public function __construct($attributes = array())
    {
        $this->hydrate($attributes);

        $this->builder = db()->table(
            $this->getTable()
        )->select();
    }

    public function __set($key, $value) {
        $this->attributes[$key] = $value;
    }

    public function __get($key)
    {
        return $this->attributes[$key];
    }

    public function hydrate($attributes = array())
    {
        $this->attributes = $attributes;

        return $this;
    }

    public static function __callStatic($method, $arguments)
    {
        $model = new static();

        $model->builder->{$method}(...$arguments);

        return $model;
    }

    public function __call($method, $arguments)
    {
        $this->builder->{$method}(...$arguments);

        return $this;
    }

    public function get() {
        return (new Arr($this->builder->get()))->map(function ($item) {
            return new static($item);
        });
    }

    public function first()
    {
        return new static($this->builder->first());
    }
}