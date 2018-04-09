<?php

namespace App\Controllers;

class Controller
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function notFound()
    {
        return array('error' => 404);
    }
}
