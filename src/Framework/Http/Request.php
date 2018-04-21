<?php

namespace Framework\Http;

use Framework\Support\ParameterBag;

class Request
{
    /**
     * The Files parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $files;

    /**
     * The Coookie parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $cookies;

    /**
     * The Server parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $server;

    /**
     * The Get parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $query;

    /**
     * The FILE parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $input;

    /**
     * The Attributes parameter bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    public $attributes;

    /**
     * Creates the parameter bags.
     */
    public function __construct()
    {
        $this->server = new ParameterBag($_SERVER);
        $this->query = new ParameterBag($_GET);
        $this->input = new ParameterBag($_POST);
        $this->files = new ParameterBag($_FILES);
        $this->cookies = new ParameterBag($_COOKIE);
        $this->attributes = new ParameterBag(array());
    }

    /**
     * Returns true if the server runs on HTTPS.
     *
     * @return bool
     */
    public function isSecure()
    {
        return $this->server->has('HTTPS');
    }

    /**
     * Returns the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->server->get('REQUEST_METHOD');
    }

    /**
     * Returns the request uri.
     *
     * @return string
     */
    public function uri()
    {
        return ltrim($this->server('REQUEST_URI'), '/');
        $scriptPath = str_replace('index.php', '', $this->server->get('SCRIPT_NAME'));

        return str_replace($scriptPath, '', $this->server->get('REQUEST_URI'));
    }

    /**
     * Returns the full request url.
     *
     * @return string
     */
    public function url()
    {
        return $this->urlBase() . '/' . $this->uri();
    }

    /**
     * Returns the url base.
     *
     * @return string
     */
    public function urlBase()
    {
        return ($this->isSecure() ? 'https' : 'http') . '://' . $this->server->get('HTTP_HOST');
    }

    /**
     * Gets the locale from the uri.
     *
     * @return string
     */
    public function evaluateLocale()
    {
        $segments = explode(
            '/',
            $this->uri()
        );

        if (! in_array($segments[0], config('locales')['locales'])) {
            return false;
        }

        return $segments[0];
    }

    /**
     * Returns a route attribute.
     *
     * @param string $key
     * @return void
     */
    public function attribute($key)
    {
        return $this->attributes->get($key);
    }

    /**
     * Returns a server variable.
     *
     * @param string $key
     * @return void
     */
    public function server($key)
    {
        return $this->server->get($key);
    }

    /**
     * Returns a GET variable.
     *
     * @param string $key
     * @return void
     */
    public function query($key)
    {
        return $this->query->get($key);
    }

    /**
     * Returns a POST variable.
     *
     * @param string $key
     * @return void
     */
    public function input($key)
    {
        return $this->input->get($key);
    }

    /**
     * Returns a FILE variable.
     *
     * @param string $key
     * @return void
     */
    public function file($key)
    {
        return $this->files->get($key);
    }
}

