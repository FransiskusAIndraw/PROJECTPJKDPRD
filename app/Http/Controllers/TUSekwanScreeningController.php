<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;

class TUSekwanScreeningController extends Controller
{
    /**
     * Display a listing of surat masuk pending screening.
     */
    public function index()
    {
        $suratMasuks = SuratMasuk::where('status_screening', 'pending')->get();
        return view('tusekwan.screening.index', compact('suratMasuks'));
    }

    /**
     * Show detail + screening form
     */
    public function show($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        return view('tusekwan.screening.show', compact('surat'));
    }

    /**
     * Process screening decision
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status_screening' => 'required|in:approved,rejected',
            'catatan_tusekwan' => 'nullable|string|max:1000',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $surat->update([
            'status_screening' => $validated['status_screening'],
            'catatan_tusekwan' => $validated['catatan_tusekwan'],
            'screened_by' => Auth::id(),
        ]);

        return redirect()->route('tusekwan.screening.index')
            ->with('success', 'Screening berhasil diperbarui.');
    }
}
