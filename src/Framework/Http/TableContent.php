<?php

namespace Framework\Http;

class TableContent
{
    protected $routes = array();
    protected const TABLE = '_tblcontent';
    protected $request;
    const PATTERN = "~{(.*)}~";
    protected $routeAttributeKeys = array();

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function getRoutes()
    {
        $prepared = db()->prepare("SELECT url_".app()->getLocale(). " as url, method, url_handle, controller, status_".app()->getLocale()." as status FROM ".self::TABLE. " WHERE status_".app()->getLocale()." >= :status");
        $prepared->execute(array(
            'status' => 2
        ));

        $this->routes = $prepared->fetchAll();
    }

    public function match(Request $request)
    {
        $this->getRoutes();

        $this->request = $request;
        $routes = array_filter($this->routes, ['self', 'filterMethod']);

        $compiled = array_map(function($route) {
            return $this->compile($route);
        }, $routes);

        $routeInfo = $this->matchCompiledRoutes($compiled);
        return $routeInfo;
    }

    protected function filterMethod($route)
    {
        return $route['method'] === $this->request->method();
    }

    protected function compile($route)
    {
        $route['compiled'] = '~' . $route['url'] . '~';

        if (preg_match(self::PATTERN, $route['url'], $matches)) {
            $this->routeAttributeKeys[] = $matches[1];
            $route['compiled'] = str_replace($matches[0], '(.*)', $route['compiled']);
        }

        return $route;
    }

    protected function matchCompiledRoutes($compiled)
    {
        $uri = str_replace(app()->getLocale().'/', '', $this->request->uri());
        foreach ($compiled as $route)
        {
            if ( preg_match(
                    $route['compiled'],
                    $uri,
                    $matches) 
                ) {
                if ( isset($this->routeAttributeKeys[0]) ) {
                    $this->request->attributes->add($this->routeAttributeKeys[0], $matches[1]);
                }
                return $route;
            }
        }
    }
}
