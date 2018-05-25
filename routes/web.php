<?php

$router->get('products/{product}', function (Framework\Http\Request $request) {
    return view('home');
})->name('product');
