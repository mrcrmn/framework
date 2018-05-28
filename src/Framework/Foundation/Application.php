<?php

namespace Framework\Foundation;

use Framework\Foundation\Container;

class Application extends Container
{
    /**
     * The locale.
     *
     * @var string
     */
    protected $locale;

    /**
     * Determines if the website is local, beta or online.
     *
     * @var int
     */
    protected $status;

    /**
     * Array of all registered services.
     *
     * @var array
     */
    protected $providers = array();

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
     * Registers and then boots all services.
     *
     * @return void
     */
    public function makeServices()
    {
        $this->providers = $this->get('config')->get('providers');

        $instances = array();

        foreach ($this->providers as $provider)
        {
            $instance = new $provider;

            $instance->register($this);

            $instances[] = $instance;
        }

        foreach ($instances as $instance) {
            $instance->boot();
        }
    }

    /**
     * Evaluates the status.
     *
     * @return void
     */
    public function setStatus()
    {
        $host = $_SERVER['HTTP_HOST'];
        $status = $this->get('config')->get('status');

        switch ($host) {
            case $status['local']:
                $this->status = 1;
                break;
            case $status['beta']:
                $this->status = 2;
                break;
            case $status['online']:
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

    /**
     * Returns true if we use the database.
     *
     * @return bool
     */
    public function hasDb()
    {
        return (bool) config('database')['use_db'];
    }

    /**
     * Sets the error reporting.
     *
     * @return void
     */
    public function setErrorReporting()
    {
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }
}
