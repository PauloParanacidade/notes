<?php

namespace App\Http\Controllers;

use Dotenv\Parser\Value;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($Value)
    {
        return view('main', ['value' => $Value]);
    }
     public function page2($Value)
    {
        return view('page2', ['value' => $Value]);
    }
     public function page3($Value)
    {
        return view('page3', ['value' => $Value]);
    }
}
