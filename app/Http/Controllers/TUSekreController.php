<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TUSekreController extends Controller
{
        public function dashboard()
    {
        return view('tu_sekre.dashboard');
    }
}
