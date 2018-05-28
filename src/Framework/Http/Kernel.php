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

    /**
     * Constructs the kernel.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handles the request and returns the response.
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request)
    {
        $this->request = $request;

        $route = app('router')->run();

        $this->request->setAttributes($route->getAttributes());

        $content = $this->dispatchController(
            $route->action()
        );

        if ($content instanceof Response) {
            return $content;
        }

        return new Response($content);
    }

    /**
     * Terminates the request.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        die();
    }

    /**
     * Dispatches the controller and gets the content.
     *
     * @param Closure|string $controller
     * @return void
     */
    protected function dispatchController($controller)
    {
        if ($controller instanceof \Closure) {
            return $controller($this->request);
        }

        $data = explode('::', $controller);
        $controller = self::CONTROLLER_NAMESPACE.$data[0];
        $instance = new $controller;
        $method = $data[1];

        return call_user_func_array(array($instance, $method), array($this->request));
    }

}
