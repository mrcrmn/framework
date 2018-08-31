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
     * All available verbs.
     *
     * @var array
     */
    protected $verbs = array(
        'GET', 'POST', 'PUT', 'DELETE', 'PATCH', 'OPTIONS'
    );

    public function __call($method, $arguments)
    {
        $verb = strtoupper($method);
        $url = '/' . ltrim($arguments[0], '/');
        $action = $arguments[1];

        if (in_array($verb, $this->verbs)) {
            return $this->addRoute($verb, $url, $action);
        }
    }

    /**
     * registers a route.
     *
     * @param string $route
     * @return string
     */
    protected function addRoute($verb, $url, $action)
    {
        if (! array_key_exists($url, $this->routes)) {
            $index = count($this->routes);

            $this->routes[$index] = new Route($url, $index);
        }

        return $this->routes[$index]->addAction($verb, $action);
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

    protected function getAttributes($matches)
    {
        $attributes = array();
        foreach ($matches as $key => $value) {
            if (strpos($key, '_') !== false) {
                $temp = explode('_', $key);
                if ($temp[0] === 'route') {
                    $attributes['route'] = $temp[1];
                } else {
                    $attributes[$temp[0]] = $value;
                }
            }
        }

        return $attributes;
    }

    protected function getMatches($regex)
    {
        preg_match($regex, request()->uri(), $matches);

        return array_filter($matches);
    }

    /**
     * Runs the Matcher.
     *
     * @return array|null The Route Info.
     */
    public function run()
    {
        $compiler = new RouteCompiler($this->routes);
        $regex = $compiler->makeRegex();

        $matches = $this->getMatches($regex);

        $attributes = $this->getAttributes($matches);
        $index = $attributes['route'];
        unset($attributes['route']);

        $action = $this->routes[$index]->getAction(
            request()->method()
        );

        return compact('attributes', 'action');
    }

}
