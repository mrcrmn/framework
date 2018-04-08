<?php

namespace Framework\View;

class ViewFactory
{   
    /**
     * The path to the views.
     *
     * @var string
     */
    protected $path;

    /**
     * The default layout.
     *
     * @var string
     */
    protected $layout = "layouts.app";

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct()
    {
        $this->path = base_path('resource/views/');
    }

    /**
     * Gets the path to a view.
     *
     * @param string $view
     * @return void
     */
    protected function getView($view)
    {
        return $this->path . str_replace('.', '/', $view) . '.php';
    }

    /**
     * Makes a view.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function make($view, $data = array())
    {
        extract($data);
        ob_start();
        require_once $this->getView($view);
        $yielded = ob_get_clean();

        require_once $this->getView($this->layout);

        $content = ob_get_clean();

        return $content;
    }
}
