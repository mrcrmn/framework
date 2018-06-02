<?php

namespace App\Controllers;

use Framework\Http\Request;
use App\Controllers\Controller;
use Framework\Support\Arr;

class ProductController extends Controller
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function index(Request $request)
    {
        $array = new Arr();
    }

    public function upload(Request $request)
    {
        $request->file('datei')->store('public/test.jpg');
    }
}
