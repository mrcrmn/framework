<?php

namespace Framework\View;

use Framework\View\Compiler;
use Framework\Support\ParameterBag;

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
        $this->rendered = new ParameterBag();
    }

    /**
     * Holds all already rendered views and its compiled paths.
     * 
     * @var \Framework\Support\ParameterBag
     */
    public $rendered;

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
     * Renders a view.
     *
     * @param string $view
     * @return string
     */
    protected function render($view)
    {
        extract($this->data);
        ob_start();

        if ($this->rendered->has($view)) {
            $path = $this->rendered->get($view);
        } else {
            $compiler = new Compiler(
                base_path('resource/compiled/'),
                $this->getView($view),
                $view
            );

            $path = $compiler->compile();
            $this->rendered->add($view, $path);
        }

        require $path;

        return ob_get_clean();
    }

    /**
     * Sets the base view to extend.
     *
     * @param string $view
     * @return void
     */
    public function extend($view)
    {
        $this->extend = $view;
    }

    /**
     * Marks the start of a new section.
     *
     * @param string $section
     * @return void
     */
    public function startSection($section)
    {
        ob_start();
        $this->activeSection = $section;
    }

    /**
     * Ends a section.
     *
     * @return void
     */
    public function endSection()
    {
        if (!isset($this->activeSection)) {
            throw new \Exception("You need to start a section before you can end it.");
        }

        $this->sections[$this->activeSection] = ob_get_clean();
        $this->activeSection = null;
    }

    /**
     * Includes a simple view.
     *
     * @param string $view
     * @return string
     */
    public function include($view)
    {
        return $this->render($view);
    }

    /**
     * Adds a yielded section to the view.
     *
     * @param string $section
     * @return string
     */
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
