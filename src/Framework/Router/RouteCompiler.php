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
     * @param array $routes
     */
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    private function compileRouteFragment(Route $route)
    {
        return "(^{$route->uri()}$)(*MARK:{$route->index})";
    }

    private function compileRouteAttributes($match)
    {
        return "(?<{$match[1]}>[^/]+)";
    }

    public function makeRegex()
    {
        $uris = array_map(function($route) {
            return $this->compileRouteFragment($route);
        }, $this->routes);

        $temp = '#' . implode('|', $uris) . '#';

        return preg_replace_callback('#\{(.+?)\}#', array($this, 'compileRouteAttributes'), $temp);
    }
}