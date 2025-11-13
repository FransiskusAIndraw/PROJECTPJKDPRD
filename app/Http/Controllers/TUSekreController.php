<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TUSekreController extends Controller
{
    public function dashboard()
    {
        return view('tusekre.dashboard', [
            'suratMasuk'  => \App\Models\SuratMasuk::count(),
            'suratArsip'  => \App\Models\Arsip::count(),
            'suratRevisi' => \App\Models\SuratMasuk::where('status', 'perlu_revisi')->count(),
        ]);
    }
}
