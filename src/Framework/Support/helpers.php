<?php

function dd($var) {
    dump($var);
    die();
}

function dump($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
}

function performance($die = false)
{
    dump(
        (microtime(true) - START_TIME) * 1000 . 'ms'
    );

    if ($die) {
        die();
    }
}

function arr($array = array())
{
    return new Framework\Support\Arr(is_array($array) ? $array : func_get_args());
}

function app($service = null) {
    global $app;

    if (isset($service)) {
        return $app->get($service);
    }

    return $app;
}

function response($content = "", $status = 200, $headers = array()) {
    return new Framework\Http\Response($content, $status, $headers);
}

function request($key = null) {
    if (! isset($key)) {
        return app('request');
    }

    return app('request')->input($key);
}

function abort($status = 404, $message = null) {
    if (! isset($message)) {
        $message = Framework\Http\Response::$statusTexts[$status];
    }

    $errorContent = request()->method('GET') 
        ? view('error', array('message' => $message))
        : array('error' => $status, 'message' => $message);

    $errorResponse = response($errorContent, $status);

    $errorResponse->send();
    die();
}

function redirect($url) {
    return response("Redirecting...", Framework\Http\Response::HTTP_MOVED_PERMANENTLY, array('Location' => $url));
}

function db() {
    return app('db');
}

function fs() {
    return app('file');
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

function session($key = null) {
    if (isset($key)) {
        return app('session')->session->get($key);
    }

    return app('session')->session;
}

function csrf_token() {
    return app('session')->getCsrfToken();
}

function asset($asset, $version = false) {
    return app('asset')->get($asset, $version);
}

function __($key) {
    return app('trans')->get($key);
}

function url($handle, $attributes = array()) {
    return app('router')->getUrl($handle, $attributes);
}