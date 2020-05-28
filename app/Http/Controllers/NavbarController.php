<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends Controller
{
    public function home(){
        return view('home');
    }

    public function results(){
        return view('results');
    }

    public function proceduresDocs(){
        return view('proceduresDocs');
    }
}
