<?php

namespace Framework\View;

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
    }

    /**
     * Maps to all available compiling methods.
     *
     * @return void
     */
    protected function compileAll()
    {
        $this->compileEcho();
        $this->compileExtend();
        $this->compileSection();
        $this->compileInclude();
        $this->compileYield();
        $this->compileForeach();
        $this->compileIf();
        $this->compileLang();
    }

    /**
     * Compiles "{{" and "}}".
     *
     * @return void
     */
    protected function compileEcho()
    {
        $this->buffer = preg_replace(
            '/(@)?{{\s*(.+?)\s*}}(\r?\n)?/s',
            '<?php echo $2; ?>',
            $this->buffer
        );
    }

    /**
     * Compiles @extend($baseView).
     *
     * @return void
     */
    protected function compileExtend()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*extends\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php view()->extend($2); ?>\r\n",
            $this->buffer
        );
    }

    /**
     * Compiles @section($section) and $endsection
     *
     * @return void
     */
    protected function compileSection()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*section\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php view()->startSection($2); ?>\r\n",
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endsection\s*/s',
            "<?php view()->endSection(); ?>\r\n",
            $this->buffer
        );
    }

    /**
     * Compiles @include($view).
     *
     * @return void
     */
    protected function compileInclude()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*include\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php echo view()->include($2); ?>\r\n",
            $this->buffer
        );
    }

    /**
     * Compiles @yield($section)
     *
     * @return void
     */
    protected function compileYield()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*yield\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php echo view()->yield($2); ?>\r\n",
            $this->buffer
        );
    }

    /**
     * Compiles @lang($handle).
     *
     * @return void
     */
    protected function compileLang()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*lang\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php echo __($2); ?>",
            $this->buffer
        );
    }

    /**
     * Compiles @foreach ($array as $key => $value) and @endforeach.
     *
     * @return void
     */
    protected function compileForeach()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*foreach\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php foreach ($2): ?>\r\n",
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endforeach\s*/s',
            "<?php endforeach; ?>\r\n",
            $this->buffer
        );
    }

    /**
     * Compiles @if($bool) and @endif
     *
     * @return void
     */
    protected function compileIf()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*if\s*\((.+?)\s*\)(\r?\n)?/s',
            "<?php if ($2): ?>\r\n",
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endif\s*/s',
            "<?php endif; ?>\r\n",
            $this->buffer
        );
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
     * Returns the compiled view path.
     *
     * @return void
     */
    public function compile()
    {
        $this->hash = $this->makeHash();
        $compiledPath = $this->path . $this->hash . '.php';

        if (! app('file')->exists($compiledPath)) {
            $this->compileAll();
            app('file')->put($compiledPath, $this->buffer);
        }

        return $compiledPath;
    }

}
