<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TUSekwanController extends Controller
{
        public function dashboard()
    {
        return view('tu_sekre.dashboard');
    }
}
