<?php

namespace App\Http\Controllers;

use App\Models\PendidikanStatistik;

class PendidikanStatistikController extends Controller
{
    public function index()
    {
        $data = PendidikanStatistik::with('tahunData')->latest()->first();

        return view('Infografis.index', compact('data'));
    }
}
