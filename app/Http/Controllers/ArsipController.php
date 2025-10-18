<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;

class ArsipController extends Controller
{
    /**
     * Display all archived surat.
     */
    public function index()
    {
        $arsipSurat = SuratMasuk::where('status', 'arsip')->latest()->get();
        return view('arsip.index', compact('arsipSurat'));
    }

    /**
     * Show list of surat eligible for archiving.
     */
    public function create()
    {
        // Surat yang sudah selesai disposisi, belum diarsipkan
        $eligible = SuratMasuk::where('status', 'selesai')->get();
        return view('arsip.create', compact('eligible'));
    }

    /**
     * Store surat as archived.
     */
    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
        ]);

        $surat = SuratMasuk::findOrFail($request->surat_masuk_id);
        $surat->update(['status' => 'arsip']);

        return redirect()->route('arsip.index')->with('success', 'Surat berhasil diarsipkan.');
    }
}
