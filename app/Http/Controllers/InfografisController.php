<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function index()
{
    return view('Infografis.index'); 
}
}
