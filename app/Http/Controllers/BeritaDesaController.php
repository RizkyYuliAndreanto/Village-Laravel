<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaDesaController extends Controller
{
    public function index()
{
    return view('Berita.index'); 
}
}
