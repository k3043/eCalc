<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    public function index(){
        $title = "Hello World!";
        return view('helloworld',compact('title'));
    }
}