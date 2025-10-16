<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat = SuratMasuk::latest()->paginate(10);
        return view('admin.surat_masuk.index', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat_masuk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|unique:surat_masuk,no_surat|max:255',
            'pengirim' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'file_surat' => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_surat')) {
            $validated['file_surat'] = $request->file('file_surat')->store('surat_masuk', 'public');
        }

        $validated['status_surat'] = 'Menunggu'; // default status

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratMasuk $surat_masuk)
    {
        return view('admin.surat_masuk.show', ['surat' => $surat_masuk]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratMasuk $surat_masuk)
    {
        return view('admin.surat_masuk.edit', ['surat' => $surat_masuk]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratMasuk $surat_masuk)
    {
        $validated = $request->validate([
            'no_surat' => 'required|max:255|unique:surat_masuk,no_surat,' . $surat_masuk->id,
            'pengirim' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'file_surat' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_surat')) {
            // Delete old file
            if ($surat_masuk->file_surat) {
                Storage::disk('public')->delete($surat_masuk->file_surat);
            }

            // Save new file
            $validated['file_surat'] = $request->file('file_surat')->store('surat_masuk', 'public');
        }

        $surat_masuk->update($validated);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratMasuk $surat_masuk)
    {
        if ($surat_masuk->file_surat) {
            Storage::disk('public')->delete($surat_masuk->file_surat);
        }

        $surat_masuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat berhasil dihapus.');
    }
}
