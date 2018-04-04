<?php

namespace Framework\Foundation;

use Framework\Support\ParameterBag;

class Application
{
    /**
     * The bag of services.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $services;

    public function __construct()
    {
        $this->services = new ParameterBag(array());
    }
    
    public function bind($key, $instance)
    {
        $this->services->add($key, $instance);
    }

    public function get($key)
    {
        return $this->services->get($key);
    }

    public function __call($name, $arguments = array())
    {
        $service = $this->get($name);

        if (!empty($arguments)) {
            return $service($arguments);            
        }

        return $service;
    }
}
