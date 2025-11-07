<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KabagKeuanganController extends Controller
{
    public function dashboard()
    {
        // view yang sudah kamu buat: resources/views/kabag/keuangan/dashboard.blade.php
        return view('kabag.keuangan.dashboard');
    }
}
