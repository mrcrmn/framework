<?php

namespace App\Controllers;

use Framework\Http\Request;
use App\Controllers\Controller;

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
            'title' => $request->attributes->get('product')
        ));
    }
}
