<?php

namespace App\Controllers;

use App\Models\Product;
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
        $products = Product::where('id', '>', 0)->first();

        return view('home', array('text' => 'hallo'));
    }

    public function upload(Request $request)
    {
        $request->file('datei')->store('public/test.jpg');
    }
}
