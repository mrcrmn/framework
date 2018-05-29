<?php

namespace App\Controllers;

use Framework\Http\Request;
use App\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function index(Request $request)
    {
        return view('home', array(
            'product' => $request->product
        ));
    }

    public function test(Request $request)
    {
        return $request->attributes->all();
    }
}
