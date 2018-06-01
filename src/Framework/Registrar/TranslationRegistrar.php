<?php

namespace Framework\Registrar;

use Framework\Foundation\Application;
use Framework\Translation\Translator;
use Framework\Registrar\Interfaces\Registrar;

class TranslationRegistrar implements Registrar
{
    public function register(Application $app)
    {
        $app->bind('trans', new Translator);
    }

    public function booted()
    {

    }
}