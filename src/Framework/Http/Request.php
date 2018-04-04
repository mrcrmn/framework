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
     * The Post parameter bag.
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
        return $this->server->get['REQUEST_METHOD'];
    }

    /**
     * Returns the request uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->server->get('REQUEST_URI');
    }

    /**
     * Returns the full request url.
     *
     * @return string
     */
    public function url()
    {
        return $this->url_base() . $this->uri();
    }

    /**
     * Returns the url base.
     *
     * @return string
     */
    public function url_base()
    {
        return ($this->isSecure() ? 'https' : 'http') . '://' . $this->server->get('HTTP_HOST');
    }
}