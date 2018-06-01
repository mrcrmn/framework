<?php

$router->get('home', 'ProductController::index')->name('home');
$router->post('upload', 'ProductController::upload')->name('upload');
