<?php

namespace Framework\Router;

use Framework\Router\RouteCompiler;

class Route
{
    /**
     * The routes name.
     *
     * @var string
     */
    public $name;

    /**
     * The compiled route uri.
     *
     * @var string
     */
    public $compiled;

    /**
     * The HTTP method of this route.
     *
     * @var string
     */
    protected $method;

    /**
     * The give uri of this route.
     *
     * @var string
     */
    protected $uri;

    /**
     * The action name of this route.
     *
     * @var string
     */
    protected $action;

    /**
     * The route attributes.
     *
     * @var array
     */
    public $attributes = array();

    /**
     * The populated route attributes.
     *
     * @var array
     */
    protected $populatedAttributes = array();

    /**
     * Constructs the Route Object.
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     */
    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $this->normalizeUri($uri);
        $this->action = $action;
    }

    /**
     * Normalizes the route and trims all prepending slashes.
     *
     * @param string $uri
     * @return string
     */
    protected function normalizeUri($uri)
    {
        return ltrim($uri, '/');
    }

    /**
     * Sets the route name.
     *
     * @param string $name
     * @return $this
     */
    public function name($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Getter for the uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->uri;
    }

    /**
     * Getter for the action.
     *
     * @return string
     */
    public function action()
    {
        return $this->action;
    }

    /**
     * Adds a route attribute to the array.
     *
     * @param string $attribute
     * @return void
     */
    public function addAttribute($attribute)
    {
        $this->attributes[] = trim($attribute, '{}');
    }

    /**
     * Gets the populated attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->populatedAttributes;
    }

    /**
     * Compiles the route.
     *
     * @return void
     */
    public function compile()
    {
        $compiler = new RouteCompiler($this);
        $this->compiled = $compiler->compile();
    }

    /**
     * Populates the attributes.
     *
     * @param array $matches
     * @return array
     */
    private function populateAttributes($matches)
    {
        if (count($this->attributes) !== count($matches)) {
            throw new \Exception("Count of attributes doesn't match.");
        }

        $ret = array();

        for ($i = 0; $i < count($this->attributes); $i++) {
            $ret[$this->attributes[$i]] = $matches[$i];
        }

        return $ret;
    }

    /**
     * Matches the compiled route to the Request Uri.
     *
     * @param string $uri
     * @return void
     */
    public function match($uri)
    {
        preg_match($this->compiled, $uri, $matches);

        if (! empty($matches)) {
            array_shift($matches);

            $this->populatedAttributes = $this->populateAttributes($matches);

            return $this;
        }

        return false;
    }

}