<?php

namespace Framework\Router;

use Framework\Router\Route;

class RouteCollection
{
    /**
     * The route collection.
     *
     * @var array
     */
    protected $routes = array();

    /**
     * Registers a get route.
     *
     * @param string $url
     * @param string $action
     * @return void
     */
    public function get($url, $action)
    {
        return $this->addRoute(new Route('GET', $url, $action));
    }

    /**
     * Registers a post route.
     *
     * @param string $url
     * @param string $action
     * @return void
     */
    public function post($url, $action)
    {
        return $this->addRoute(new Route('POST', $url, $action));
    }

    /**
     * registers a route.
     *
     * @param string $route
     * @return string
     */
    protected function addRoute($route)
    {
        $this->routes[] = $route;

        return $route;
    }

    /**
     * Requires a route group.
     *
     * @param Callable $callback
     * @return $this
     */
    public function group($callback)
    {
        $callback($this);

        return $this;
    }

    /**
     * Generates a link to a specified route name.
     *
     * @param string $name
     * @param array $attributes
     * @return string
     */
    public function getUrl($name, $attributes = array())
    {
        $namedRoute;

        foreach ($this->routes as $route)
        {
            if ($route->name === $name) {
                $namedRoute = $route;
                break;
            }
        }

        if (count($namedRoute->attributes) !== count($attributes)) {
            throw new \Exception("Number of given attributes don't match");
        }

        $link = $route->uri();

        foreach ($attributes as $attribute => $value) {
            $link = str_replace('{'.$attribute.'}', $value, $link);
        }

        return implode('/', array(
            request()->urlBase(),
            $link
        ));
    }

    /**
     * Runs the Matcher.
     *
     * @return array|null The Route Info.
     */
    public function run()
    {
        foreach ($this->routes as $route)
        {
            $route->compile();
        }

        foreach ($this->routes as $route)
        {
            $match = $route->match(
                request()->uri()
            );

            if ($match !== false && $route->isMethod(request()->method())) {
                return $match;
                break;
            }
        }
    }

}