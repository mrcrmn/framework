<?php

namespace App\Controllers;

use Framework\Http\Request;

class HomeController
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function index(Request $request)
    {
        return "hallo";
    }
}
