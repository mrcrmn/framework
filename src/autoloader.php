<?php

function __autoload($class)
{
    $path = str_replace('\\', '/', $class);

    require_once base_path('src/'.$path.'.php');
}

spl_autoload_register('__autoload');
