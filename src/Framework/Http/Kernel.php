<?php

namespace Framework\Http;

use Framework\Http\Request;
use Framework\Http\Response;

class Kernel
{
    /**
     * The Request Instance.
     *
     * @var \Framework\Http\Request
     */
    public $request;

    public function handle(Request $request)
    {
        $this->request = $request;

        return new Response();
    }

    public function terminate(Request $request, Response $response)
    {
        die();
    }
}
