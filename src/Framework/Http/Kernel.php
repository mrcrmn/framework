<?php

namespace Framework\Http;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Foundation\Application;

class Kernel
{
    /**
     * The Request Instance.
     *
     * @var \Framework\Http\Request
     */
    public $request;

    /**
     * The App Instance.
     *
     * @var \Framework\Foundation\Appliction
     */
    protected $app;

    /**
     * The Controller Namespace.
     * 
     * @var string
     */
    const CONTROLLER_NAMESPACE = "App\\Controllers\\";

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request)
    {
        $this->request = $request;
        $this->app->setLocale($this->request->evaluateLocale());

        $routeInfo = app('router')->match($this->request);

        $content = $this->dispatchController(
            $routeInfo['controller']
        );

        return new Response($content);
    }

    public function terminate(Request $request, Response $response)
    {
        die();
    }

    protected function dispatchController($controller)
    {
        $data = explode('::', $controller);
        $controller = self::CONTROLLER_NAMESPACE.$data[0];
        $method = $data[1];

        return call_user_func_array(array($controller, $method), array($this->request));
    }

}
