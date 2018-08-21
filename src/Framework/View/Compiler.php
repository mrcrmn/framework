<?php

namespace Framework\View;

use Framework\View\ExpressionRenderer;

class Compiler
{
    /**
     * The path to the compiled views.
     *
     * @var string
     */
    protected $path;

    /**
     * The path to this view.
     *
     * @var string
     */
    protected $viewPath;

    /**
     * The current compiled view buffer.
     *
     * @var string
     */
    protected $buffer;

    /**
     * The hash of the compiled template.
     *
     * @var string
     */
    protected $hash;

    /**
     * The name of the view.
     *
     * @var string
     */
    protected $view;

    protected $renderer;

    /**
     * Constructs a new view compiler.
     *
     * @param string $compiledViewPath The path to the compiled views.
     * @param atring $viewPath The path to the current view.
     * @param string $viewName The name of the current view.
     */
    public function __construct($compiledViewPath, $viewPath, $viewName)
    {
        $this->path = $compiledViewPath;
        $this->viewPath = $viewPath;
        $this->buffer = app('file')->get($viewPath);
        $this->view = $viewName;
        $this->renderer = new ExpressionRenderer();
    }

    /**
     * Makes the compiled hash.
     *
     * @return void
     */
    protected function makeHash()
    {
        $hash = "";
        $string = $this->view . app('file')->lastModified($this->viewPath);
        return hash('md4', $string);
    }

    /**
     * Dispatches each expression to the Render engine.
     *
     * @param array $matches
     * @return string
     */
    public function handleExpression($matches)
    {
        // Special handling for echos.
        if (strpos($matches[0], '{{') === 0) {
            return call_user_func(array($this->renderer, 'renderEcho'), $matches[2]);
        }

        $expression = array(
            'escaped' => (bool) $matches[1],
            'expression' => $matches[2],
            'arguments' => isset($matches[4]) ? trim($matches[4]) : null
        );
        
        $method = 'render' . ucfirst($expression['expression']);

        if (! $expression['escaped'] && method_exists($this->renderer, $method)) {

            return call_user_func(
                array($this->renderer, $method),
                $expression['arguments']
            );
        }
        
        return $matches[0];
    }

    /**
     * Matches the buffer for expressions.
     *
     * @param string $buffer
     * @return string
     */
    public function runCompiler($buffer)
    {
        return preg_replace_callback(
            array(
                '/(@)?@\s*([a-zA-Z]*)\s*(\(\s*(.+)\s*\))?(\r?\n)?/m',
                '/(@)?{{\s*(.*)\s*}}(\r?\n)?/m',
            ),
            array($this, 'handleExpression'),
            $buffer
        );
    }

    /**
     * Returns the compiled view path after it saved the file.
     *
     * @return string
     */
    public function compile()
    {
        $this->hash = $this->makeHash();
        $compiledPath = $this->path . $this->hash . '.php';

        if (! app('file')->exists($compiledPath) || true) {
            app('file')->put($compiledPath, $this->runCompiler($this->buffer));
        }

        return $compiledPath;
    }

}
