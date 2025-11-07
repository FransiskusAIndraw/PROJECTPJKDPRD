<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;

class KabagDisposisiController extends Controller
{
    /**
     * Tampilkan daftar disposisi yang ditujukan ke kabag saat ini.
     */
    public function index()
    {
        $user = Auth::user();

        // asumsikan kolom 'ke_user' berisi user id penerima disposisi
        $disposisis = Disposisi::with('surat')
            ->where('ke_user', $user->id)
            ->orderByDesc('tgl_disposisi')
            ->get();

        return view('kabag.disposisi.index', compact('disposisis'));
    }

    /**
     * Tandai disposisi selesai (kabag menandai selesai) -> arsipkan surat + disposisi
     */
    public function selesai(Request $request, $id)
    {
        $dispo = Disposisi::findOrFail($id);

        // optional: verifikasi penerima sama dengan user sekarang
        if ($dispo->ke_user !== auth()->id()) {
            abort(403, 'Anda bukan penerima disposisi ini.');
        }

        // update status disposisi (kamu bisa ubah field/kolom sesuai)
        $dispo->update(['status_dispo' => 'selesai']);

        // arsipkan: buat record di tabel arsip (sesuaikan kolom sesuai tabel arsipmu)
        $surat = $dispo->surat;
        if ($surat) {
            \App\Models\Arsip::create([
                'surat_id' => $surat->id,
                'disposisi_id' => $dispo->id,
                'arsipkan_oleh' => auth()->id(),
                'arsipkan_oleh_role' => auth()->user()->roles ?? null,
                'lokasi_file' => $surat->file_surat, // sesuaikan jika perlu
                'nomor_surat' => $surat->nomor_surat,
                'tanggal_surat' => $surat->tanggal_surat,
                'pengirim' => $surat->pengirim,
                'perihal' => $surat->perihal,
                'instruksi' => $dispo->instruksi,
            ]);
            // ubah status surat jadi diarsipkan
            $surat->update(['status' => SuratMasuk::STATUS_DIARSIPKAN]);
        }

        return redirect()->back()->with('success', 'Disposisi ditandai selesai dan surat diarsipkan.');
    }
}
