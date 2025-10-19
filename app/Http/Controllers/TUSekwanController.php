<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;

class TUSekwanController extends Controller
{
    

    // List all surat masuk (for monitoring / archiving)
    public function index()
    {
        $suratMasuk = SuratMasuk::orderBy('created_at', 'desc')->get();
        return view('tusekwan.surat_masuk.index', compact('suratMasuk'));
    }

    // Show detail of one surat
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('tusekwan.surat_masuk.show', compact('surat'));
    }



    public function screeningIndex()
    {
        $suratMasuk = SuratMasuk::where('status_screening', 'pending')->get();
        return view('tusekwan.screening.index', compact('suratMasuk'));
    }

    public function screeningShow($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('tusekwan.screening.show', compact('surat'));
    }

    public function screeningUpdate(Request $request, $id)
    {
        $request->validate([
            'status_screening' => 'required|in:approved,rejected',
            'catatan_screening' => 'nullable|string',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $surat->update([
            'status_screening' => $request->status_screening,
            'catatan_screening' => $request->catatan_screening,
        ]);

        return redirect()->route('tusekwan.screening.index')
            ->with('success', 'Screening updated successfully!');
    }


   public function dashboard()
{
    $stats = [
        'total' => \App\Models\SuratMasuk::count(),
        'pending' => \App\Models\SuratMasuk::where('status_screening', 'pending')->count(),
        'approved' => \App\Models\SuratMasuk::where('status_screening', 'approved')->count(),
        'rejected' => \App\Models\SuratMasuk::where('status_screening', 'rejected')->count(),
    ];

    $recentSurat = \App\Models\SuratMasuk::latest()->take(5)->get();

    return view('tusekwan.dashboard', compact('stats', 'recentSurat'));
}

}
