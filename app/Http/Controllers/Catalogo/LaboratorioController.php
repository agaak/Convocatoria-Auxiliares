<?php

namespace App\Http\Controllers\Catalogo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaboratorioController extends Controller
{
    public function index() {
        return view('catalogo.laboratorio');
    }
}
