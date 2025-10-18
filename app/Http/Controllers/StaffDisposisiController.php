<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StaffDisposisiController extends Controller
{
    public function index()
    {
        // Only disposisi sent to this staff
        $disposisis = Disposisi::with('suratMasuk', 'user')
            ->where('diteruskan_kepada', Auth::id())
            ->latest()
            ->get();

        return view('staff.disposisi.index', compact('disposisis'));
    }

    public function show($id)
    {
        $disposisi = Disposisi::with(['suratMasuk', 'user'])->findOrFail($id);

        // Prevent unauthorized access
        if ($disposisi->diteruskan_kepada !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('staff.disposisi.show', compact('disposisi'));
    }

    public function updateStatus($id)
    {
        $disposisi = Disposisi::findOrFail($id);

        if ($disposisi->diteruskan_kepada !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $disposisi->update(['status' => 'selesai']);

        return redirect()->route('staff.disposisi.index')->with('success', 'Disposisi ditandai selesai.');
    }
}
