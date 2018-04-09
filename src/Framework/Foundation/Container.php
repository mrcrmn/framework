<?php

namespace Framework\Foundation;

use Framework\Support\ParameterBag;

class Container
{
    /**
     * The bag of services.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $services;

    /**
     * Creates the Services Parameter Bag.
     */
    public function __construct()
    {
        $this->services = new ParameterBag();
    }

    /**
     * Binds a service to the application.
     *
     * @param string $key
     * @param mixed $instance
     * @return void
     */
    public function bind($key, $instance)
    {
        $this->services->add($key, $instance);

        return $instance;
    }

    /**
     * Gets a service from the services array.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->services->get($key);
    }

    /**
     * Magic function which also gets a service.
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call($name, $arguments = array())
    {
        $service = $this->get($name);

        if (!empty($arguments)) {
            return $service($arguments);
        }

        return $service;
    }
}
