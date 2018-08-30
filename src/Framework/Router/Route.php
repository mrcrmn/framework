<?php

namespace Framework\Router;

use Framework\Router\RouteCompiler;

class Route
{
    public $index;

    /**
     * The routes name.
     *
     * @var string
     */
    public $name;

    /**
     * The give uri of this route.
     *
     * @var string
     */
    protected $uri;

    /**
     * The action name of this route.
     *
     * @var array
     */
    protected $actions;

    /**
     * The route attributes.
     *
     * @var array
     */
    public $attributes = array();

    /**
     * Constructs the Route Object.
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     */
    public function __construct($uri, $index)
    {
        $this->uri = str_replace('}', '_' . $index . '}', $uri);
        $this->index = $index;
    }

    public function addAction($verb, $action)
    {
        if (isset($this->actions[$verb])) {
            throw new \Exception("Action for '$verb' does already exist.");
        }
        
        $this->actions[$verb] = $action;

        return $this;
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

    public function getAction($verb)
    {
        if (! isset($this->actions[$verb])) {
            throw new \Exception("Method not allowed");
        }
        return $this->actions[$verb];
    }

}