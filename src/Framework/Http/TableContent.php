<?php

namespace Framework\Http;

class TableContent
{
    /**
     * The collection of all routes.
     *
     * @var array
     */
    protected $routes = array();

    /**
     * The Table name.
     * 
     * @var string
     */
    const TABLE = '_tblcontent';

    /**
     * The Request Instance.
     *
     * @var \Framework\Http\Request
     */
    protected $request;

    /**
     * The compiling pattern.
     * 
     * @ver string
     */
    const PATTERN = "~{(.*)}~";

    /**
     * Saves the route attribute key.
     *
     * @var array
     */
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
            'status' => app()->getStatus()
        ));

        $this->routes = $prepared->fetchAll();
    }

    /**
     * Gets the matching route.
     *
     * @param Request $request
     * @return void
     */
    public function match(Request $request)
    {
        $this->getRoutes();

        $this->request = $request;
        $routes = array_filter($this->routes, array('self', 'filterMethod'));

        $compiled = array();

        foreach ($routes as $route) {
            $compiled[] = $this->compile($route);
        }

        $routeInfo = $this->matchCompiledRoutes($compiled);
        return $routeInfo;
    }

    /**
     * Filters the method for this request.
     *
     * @param array $route
     * @return void
     */
    protected function filterMethod($route)
    {
        return $route['method'] === $this->request->method();
    }

    /**
     * Compiles the route and prepares it for preg_match.
     *
     * @param array $route
     * @return void
     */
    protected static function compile($route)
    {
        $route['compiled'] = '~' . $route['url'] . '~';

        if (preg_match(self::PATTERN, $route['url'], $matches)) {
            $this->routeAttributeKeys[] = $matches[1];
            $route['compiled'] = str_replace($matches[0], '(.*)', $route['compiled']);
        }

        return $route;
    }

    /**
     * Matches the compiled route.
     *
     * @param array $compiled
     * @return void
     */
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

        return array(
            'controller' => 'Controller::notFound'
        );
    }
}
