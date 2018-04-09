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
        $product = Product::where('handle', $request->attribute('product'))->first();

        return view('home', array(
            'product' => $product
        ));
    }
}
