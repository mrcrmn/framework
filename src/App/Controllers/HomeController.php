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
        return redirect(
            url('product', array('product' => 'hallo'))
        );
    }

    public function product(Request $request)
    {
        return $request->attribute('product');
    }
}
