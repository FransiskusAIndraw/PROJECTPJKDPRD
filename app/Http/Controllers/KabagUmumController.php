<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KabagUmumController extends Controller
{
    public function dashboard()
    {
        // view yang sudah kamu buat: resources/views/kabag/umum/dashboard.blade.php
        return view('kabag.umum.dashboard');
    }
}
