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

function view($view, $data = array()) {
    return app('view')->make($view, $data);
}

function asset($asset, $version = false) {
    echo app('asset')->get($asset, $version);
}