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
        $array = arr('hallo', 'was', 'geht', 'ab');

        foreach($array as $item)
        {
            echo $item;
        }

    }

    public function upload(Request $request)
    {
        $request->file('datei')->store('public/test.jpg');
    }
}
