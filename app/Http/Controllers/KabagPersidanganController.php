<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KabagPersidanganController extends Controller
{
    public function dashboard()
    {
        // view yang sudah kamu buat: resources/views/kabag/persidangan/dashboard.blade.php
        return view('kabag.persidangan.dashboard');
    }
}
