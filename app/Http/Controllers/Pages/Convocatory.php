<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Convocatory extends Controller
{
    public function titleDescription(){
        return view('convocatory.titleDescription');
    }
    public function request(){
        return view('convocatory.request');
    }
    public function requirements(){
        return view('convocatory.requirements');
    }
    public function importantDates(){
        return view('convocatory.importantDates');
    }
    public function meritRating(){
        return view('convocatory.meritRating');
    }
    public function knowledgeRating(){
        return view('convocatory.knowledgeRating');
    }
}
