<?php

namespace Framework\Registrar;

use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;
use Framework\Filesystem\File;

class FileRegistrar implements Registrar
{
    public function register(Application $app)
    {
        $app->bind('file', new File);
    }

    public function booted()
    {

    }
}