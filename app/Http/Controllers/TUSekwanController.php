<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;


class TUSekwanController extends Controller
{

    public function screeningIndex()
    {
        $suratMasuk = SuratMasuk::where('status_screening', 'pending')->get();
        return view('tusekwan.screening.index', compact('suratMasuk'));
    }

    // Show detail of a single surat
    public function screeningShow($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('tusekwan.screening.show', compact('surat'));
    }

    // Approve or reject surat
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
        return view('tu_sekre.dashboard');
    }
}
