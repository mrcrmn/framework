<?php

function dd($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function app($service = null) {
    global $app;

    if (isset($service)) {
        return $app->get($service);
    }

    return $app;
}

function db() {
    return app('db');
}

function config($handle) {
    return app('config')->get($handle);
}

function view($view = null, $data = array()) {
    if (isset($view)) {
        return app('view')->makeView($view, $data);
    }

    return app('view');
}

function asset($asset, $version = false) {
    return app('asset')->get($asset, $version);
}

function __($key) {
    return app('trans')->get($key);
}