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
     * Determines if the website is local, beta or online
     *
     * @var int
     */
    protected $status;

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
