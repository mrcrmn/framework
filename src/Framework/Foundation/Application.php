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

    /**
     * The locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * Determines if the website is local, beta or online
     *
     * @var int
     */
    protected $status;

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
     * Magic function which gets also gets a service.
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

    /**
     * Sets the locale.
     *
     * @param string $locale
     * @return void
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * Gets the locale.
     *
     * @param string $locale
     * @return void
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Evaluates the status.
     *
     * @return void
     */
    public function setStatus()
    {
        $host = $_SERVER['HTTP_HOST'];

        switch ($host) {
            case config('status')['local']:
                $this->status = 1;
                break;
            case config('status')['beta']:
                $this->status = 2;
                break;
            case config('status')['online']:
                $this->status = 3;
                break;
            
            default:
                die('Invalid status');
                break;
        }
    }

    /**
     * Returns the status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
