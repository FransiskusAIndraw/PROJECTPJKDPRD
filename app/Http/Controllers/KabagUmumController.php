<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KabagUmumController extends Controller
{
    public function dashboard()
    {
        return view('kabag.umum.dashboard', [
            'suratArsip'       => \App\Models\Arsip::count(),
            'disposisiAktif'   => \App\Models\Disposisi::where('status_dispo', 'pending')->count(),
            'disposisiSelesai' => \App\Models\Disposisi::where('status_dispo', 'selesai')->count(),
        ]);
    }
}
