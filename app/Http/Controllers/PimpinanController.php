<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PimpinanController extends Controller
{
    public function dashboard()
    {
        return view('pimpinan.dashboard', [
            'disposisiAktif'   => \App\Models\Disposisi::where('status_dispo', 'pending')->count(),
            'disposisiSelesai' => \App\Models\Disposisi::where('status_dispo', 'selesai')->count(),
        ]);
    }
}
