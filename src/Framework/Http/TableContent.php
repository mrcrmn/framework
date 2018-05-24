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
     * All URLs for generation.
     *
     * @var array
     */
    protected $urls = array();

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
        $this->routes = db()->select('url_'.app()->getLocale().' as url', 'method', 'url_handle', 'controller', 'status_'.app()->getLocale().' as status')
                            ->from(self::TABLE)
                            ->where('status_'.app()->getLocale(), '>=', app()->getStatus())
                            ->get();

        foreach ($this->routes as $route) {
            $this->urls[$route['url_handle']] = $route['url'];
        }
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

        if ($this->request->method() === 'POST') {
            $this->verifyCsrfToken();
        }

        $routes = array_filter($this->routes, array('self', 'filterMethod'));

        $compiled = array();

        foreach ($routes as $route) {
            $compiled[] = $this->compile($route);
        }

        $routeInfo = $this->matchCompiledRoutes($compiled);
        return $routeInfo;
    }

    protected function verifyCsrfToken()
    {
        if (! session()->session->has('_token') || session('_token') !== $this->request->input('_token') ) {
            abort(406);
        }
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
    protected function compile($route)
    {
        $route['compiled'] = '~^' . $route['url'] . '$~';

        if (preg_match(self::PATTERN, $route['url'], $matches)) {
            $this->routeAttributeKeys[] = $matches[1];
            $route['compiled'] = str_replace($matches[0], '([^/]+)', $route['compiled']);
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
                if ( isset($this->routeAttributeKeys[0]) && isset($matches[1]) ) {
                    $this->request->attributes->add(
                        $this->routeAttributeKeys[0], $matches[1]
                    );
                }
                return $route;
            }
        }

        abort(404);
    }

    /**
     * Generates an url for a specific route handle.
     *
     * @param string $handle
     * @param array $attributes
     * @return string
     */
    public function getUrl($handle, $attributes = array()) {
        $url = $this->urls[$handle];

        foreach ($attributes as $attribute => $value) {
            $url = str_replace('{'.$attribute.'}', $value, $url);
        }

        return implode('/', array(
            $this->request->urlBase(),
            app()->getLocale(),
            $url
        ));
    }
}
