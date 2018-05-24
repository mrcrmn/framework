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

function response($content = "", $status = 200, $headers = array()) {
    return new Framework\Http\Response($content, $status, $headers);
}

function request() {
    return app('request');
}

function abort($status = 404, $message = null) {
    if (! isset($message)) {
        $message = Framework\Http\Response::$statusTexts[$status];
    }

    $errorResponse = response(
        view('error', array(
            'message' => $message
        )
    ), $status);

    $errorResponse->send();
    die();
}

function redirect($url) {
    return response("Redirecting...", Framework\Http\Response::HTTP_MOVED_PERMANENTLY, array('Location' => $url));
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