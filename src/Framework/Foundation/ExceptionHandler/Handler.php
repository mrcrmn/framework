<?php

namespace Framework\Foundation\ExceptionHandler;

use Framework\Support\ParameterBag;

class Handler
{
    protected $info;

    protected $error;

    public function handle_error()
    {
        $args = func_get_args();

        echo view('exception', array(
            'code' => $args[0],
            'message' => $args[1],
            'file' => $args[2],
            'line' => $args[3],
            'context' => $args[4],
            'lines' => $this->getLines($args[2])
        ));

        return true;
    }

    public function handle_exception($error)
    {
        $this->error = $error;

        echo view('exception', array(
            'code' => $this->error->getCode(),
            'message' => $this->error->getMessage(),
            'file' => $this->error->getFile(),
            'line' => $this->error->getLine(),
            'trace' => $this->error->getTrace(),
            'lines' => $this->getLines($this->error->line)
        ));

        return true;
    }

    protected function makeErrorInfo($args)
    {
        return new ParameterBag(array(
            'code' => $args[0],
            'message' => $args[1],
            'file' => $args[2],
            'line' => $args[3],
            'context' => $args[4]
        ));
    }

    protected function getLines($file)
    {
        return explode("\r", fs()->get($file));
    }
}