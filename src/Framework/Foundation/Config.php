<?php

namespace Framework\Foundation;

use Framework\Support\ParameterBag;

class Config
{
    protected $path;
    protected $configs;

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->configs = new ParameterBag(array());
    }

    protected function getConfig($handle)
    {
        return require_once $this->path . $handle . '.php';
    }

    public function get($key)
    {
        if (! $this->configs->has($key)) {
            $this->configs->add($key, $this->getConfig($key));
        }

        return $this->configs->get($key);
    }
}
