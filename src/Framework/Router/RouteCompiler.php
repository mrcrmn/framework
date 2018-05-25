<?php

namespace Framework\Router;

use Framework\Router\Route;

class RouteCompiler
{
    /**
     * The Request uri.
     *
     * @var string
     */
    protected $uri;

    /**
     * The construtor of the compiler object.
     *
     * @param Route $route
     */
    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    /**
     * compiles the route and adds optional attributes to the array.
     *
     * @return string
     */
    public function compile()
    {
        preg_match_all('#\{[^/]+\}#', $this->route->uri(), $matches);

        $compiled = $this->route->uri();
        
        if (! empty($matches[0])) {

            foreach ($matches[0] as $match) {
                $this->route->addAttribute($match);
                $compiled = str_replace($match, '([^/]+)', $compiled);
            }

        }

        return '#^' . $compiled . '$#';
    }
}