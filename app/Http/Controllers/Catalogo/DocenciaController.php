<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocenciaController extends Controller
{
    public function index() {
        return view('catalogo.docencia');
    }
}
