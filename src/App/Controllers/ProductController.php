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

    public function upload(Request $request)
    {
        $request->file('datei')->store('public/test.jpg');
    }
}
