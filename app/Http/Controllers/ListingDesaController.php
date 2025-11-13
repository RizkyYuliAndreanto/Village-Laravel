<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingDesaController extends Controller
{
    public function index()
{
    return view('Listing.index'); 
}
}
