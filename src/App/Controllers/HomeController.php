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
            url('product.comments', array('product' => 'hallo', 'comments' => 'test'))
        );
    }

    public function test(Request $request)
    {
        return $request->attributes->all();
    }
}
