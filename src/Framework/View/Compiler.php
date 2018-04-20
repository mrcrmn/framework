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
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct($compiledViewPath, $viewPath)
    {
        $this->path = $compiledViewPath;
        $this->buffer = app('file')->get($viewPath);
    }

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

    protected function compileEcho()
    {
        $this->buffer = preg_replace(
            '/(@)?{{\s*(.+?)\s*}}(\r?\n)?/s',
            '<?php echo $2; ?>',
            $this->buffer
        );
    }

    protected function compileExtend()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*extends\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php view()->extend($2); ?>',
            $this->buffer
        );
    }

    protected function compileSection()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*section\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php view()->startSection($2); ?>',
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endsection\s*/s',
            '<?php view()->endSection(); ?>',
            $this->buffer
        );
    }

    protected function compileInclude()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*include\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php echo view()->include($2); ?>',
            $this->buffer
        );
    }

    protected function compileYield()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*yield\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php echo view()->yield($2); ?>',
            $this->buffer
        );
    }

    protected function compileLang()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*lang\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php echo __($2); ?>',
            $this->buffer
        );
    }

    protected function compileForeach()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*foreach\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php foreach ($2): ?>',
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endforeach\s*/s',
            '<?php endforeach; ?>',
            $this->buffer
        );
    }

    protected function compileIf()
    {
        $this->buffer = preg_replace(
            '/(@)?@\s*if\s*\((.+?)\s*\)(\r?\n)?/s',
            '<?php if ($2): ?>',
            $this->buffer
        );

        $this->buffer = preg_replace(
            '/(@)?@\s*endif\s*/s',
            '<?php endif; ?>',
            $this->buffer
        );
    }

    protected function makeHash($string)
    {
        return md5($string);
    }

    public function compile()
    {
        $this->compileAll();

        $this->hash = $this->makeHash($this->buffer);

        $compiledPath = $this->path . $this->hash . '.php';

        if (! app('file')->exists($compiledPath)) {
            app('file')->put($compiledPath, $this->buffer);
        }

        return $compiledPath;
    }


}
