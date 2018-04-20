<?php

namespace App\Controllers;

use Framework\Http\Request;
use App\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function index(Request $request)
    {
        return view('home', array(
            'var' => 'test'
        ));
    }
}
