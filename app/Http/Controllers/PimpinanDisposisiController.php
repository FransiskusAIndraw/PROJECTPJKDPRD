<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;

class PimpinanDisposisiController extends Controller
{
    public function index()
    {
        // Ambil surat yang sudah dikirim TU Sekwan ke Pimpinan
        $suratMasuk = SuratMasuk::where('status', SuratMasuk::STATUS_DIDISPOSISIKAN_KE_PIMPINAN)->get();

        return view('pimpinan.disposisi.index', compact('suratMasuk'));
    }

    public function review($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $disposisi = $surat->disposisis()->latest()->first();

        if ($disposisi && $disposisi->status_dispo === 'dibaca') {
            $disposisi->update(['status_dispo' => 'dibaca']);
        }

        return view('pimpinan.disposisi.edit', compact('surat', 'disposisi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'instruksi_tambahan' => 'required|string|max:1000',
            
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $disposisi = $surat->disposisis()->latest()->first();

        // Tambahkan instruksi pimpinan
        $disposisi->update([
            'instruksi' => $disposisi->instruksi . "\n\nOleh PIMPINAN:\n" . $request->instruksi_tambahan,
            'status_dispo' => 'selesai',          // ✅ ubah status disposisi
            'posisi_terakhir' => 'pimpinan',      // ✅ tandai posisi terakhir
        ]);

        // Update status surat
        $surat->update([
            'status' => SuratMasuk::STATUS_DITERIMA_SEKWAN
        ]);

        return redirect()->route('pimpinan.disposisi.index')
            ->with('success', 'Disposisi berhasil dikembalikan ke TU Sekwan.');
    }
}
