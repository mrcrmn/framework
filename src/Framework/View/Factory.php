<?php

namespace Framework\View;

class Factory
{   
    /**
     * The path to the views.
     *
     * @var string
     */
    protected $path;

    /**
     * The extended layout.
     *
     * @var string
     */
    protected $extend;

    /**
     * The array of all sections.
     *
     * @var array
     */
    protected $sections = array();

    /**
     * The currently active section.
     *
     * @var string
     */
    protected $activeSection;

    /**
     * The current view data.
     * 
     * @var array
     */
    protected $data = array();

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

    protected function render($view)
    {
        extract($this->data);
        ob_start();

        $compiler = new Compiler(
            base_path('resource/compiled/'),
            $this->getView($view)
        );

        require $compiler->compile();

        return ob_get_clean();
    }

    public function extend($view)
    {
        $this->extend = $view;
    }

    public function startSection($section)
    {
        ob_start();
        $this->activeSection = $section;
    }

    public function endSection()
    {
        if (!isset($this->activeSection)) {
            throw new \Exception("You need to start a section before you can end it.");
        }

        $this->sections[$this->activeSection] = ob_get_clean();
        $this->activeSection = null;
    }

    public function include($view)
    {
        return $this->render($view);
    }

    public function yield($section) {
        return $this->sections[$section];
    }

    /**
     * Makes a view.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function makeView($view, $data = array())
    {
        $this->data = $data;
        ob_start();
        
        $this->render($view);

        if (! empty($this->extend)) {
            echo $this->render($this->extend);
        }

        $content = ob_get_clean();
        $content = app('trans')->replace($content);

        return $content;
    }
}
