<?php

namespace Framework\Http;

use Framework\Support\ParameterBag;
use Framework\Filesystem\UploadedFile;

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
        $this->files = $this->makeFiles($_FILES);
        $this->cookies = new ParameterBag($_COOKIE);
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
     * Checks if the App gets requestd in a subdirectory.
     *
     * @return bool
     */
    public function isSubDir()
    {
        return $this->server->get('SCRIPT_NAME') !== '/index.php';
    }

    /**
     * Returns the request method or checks if the given method is the request method.
     *
     * @return string
     */
    public function method($method = null)
    {
        if (isset($method)) {
            return $this->method() === $method;
        }

        return $this->server->get('REQUEST_METHOD');
    }

    /**
     * Returns the request uri.
     *
     * @return string
     */
    public function uri()
    {
        $scriptPath = str_replace('index.php', '', $this->server->get('SCRIPT_NAME'));
        $uri = '/' . str_replace($scriptPath, '', $this->server->get('REQUEST_URI'));

        return $uri;
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
        $locales = config('locales');

        $segments = explode(
            '/',
            $this->uri()
        );

        if (empty($segments)) {
            $segments[0] = $locales[0];
        }

        if (! in_array($segments[0], $locales['locales'])) {
            abort(404);
        }

        return $segments[0];
    }

    /**
     * Initialises UploadedFile objects and returns them in
     * a new ParameterBag.
     *
     * @param array $files
     * @return \Framework\Support\ParameterBag
     */
    private function makeFiles($files)
    {
        $uploadedFiles = array_map(function($file) {
            return new UploadedFile($file);
        }, $files);

        return new ParameterBag($uploadedFiles);
    }

    /**
     * Sets the request attributes.
     *
     * @param array $attributes
     * @return void
     */
    public function setAttributes($attributes = array())
    {
        $this->attributes = new ParameterBag($attributes);
    }

    /**
     * Directly binds POST and GET Parameters as Request attributes. 
     *
     * @param string $key
     * @return string
     */
    public function __get($key)
    {
        if ($this->method('POST') && $this->input->has($key)) {
            return $this->input->get($key);
        }

        if ($this->method('GET') && $this->query->has($key)) {
            return $this->query->get($key);
        }

        return $this->attributes->get($key);
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

