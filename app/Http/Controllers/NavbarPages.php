<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarPages extends Controller
{
    public function home(){
        return view('home');
    }

    public function convocatory(){
        return view('convocatory');
    }

    public function results(){
        return view('results');
    }

    public function proceduresDocs(){
        return view('proceduresDocs');
    }
}
