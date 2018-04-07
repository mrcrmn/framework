<?php

namespace Framework\Foundation;

use Framework\Support\ParameterBag;

class Config
{
    /**
     * The path to the config folder.
     *
     * @var string
     */
    protected $path;

    /**
     * All the saved configurations.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $configs;

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
        $this->configs = new ParameterBag();
    }

    /**
     * Gets a config file.
     *
     * @param string $handle
     * @return void
     */
    protected function getConfig($handle)
    {
        return require_once $this->path . $handle . '.php';
    }

    /**
     * Gets the configuration array.
     *
     * @param string $key
     * @return void
     */
    public function get($key)
    {
        if (! $this->configs->has($key)) {
            $this->configs->add($key, $this->getConfig($key));
        }

        return $this->configs->get($key);
    }
}
