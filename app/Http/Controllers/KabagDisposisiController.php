<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class KabagDisposisiController extends Controller
{
    /**
     * Menampilkan daftar surat yang sudah diteruskan ke Kabag.
     * Ini akan dipanggil oleh semua Kabag tanpa dibedakan bidangnya.
     */
    public function index()
    {
        // Ambil semua surat yang statusnya menunggu diproses kabag
        $suratUntukKabag = SuratMasuk::where('status', SuratMasuk::STATUS_DITERUSKAN_KE_KABAG)->get();

        return view('kabag.disposisi.index', compact('suratUntukKabag'));
    }

    /**
     * Kabag menandai disposisi telah selesai → Surat masuk diarsipkan.
     */
    public function selesai($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $surat->update([
            'status' => SuratMasuk::STATUS_DIARSIPKAN
        ]);

        return redirect()->back()->with('success', 'Surat telah diproses dan diarsipkan.');
    }
}
