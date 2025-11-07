<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tandai 1 notifikasi sebagai terbaca lalu redirect.
     * Jika kolom `url` ada di tabel notifikasi, redirect ke url tsb.
     * Kalau tidak ada, redirect back.
     */
    public function read($id)
    {
        $userId = Auth::id();

        $notif = Notifikasi::where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (! $notif) {
            return redirect()->back()->with('error', 'Notifikasi tidak ditemukan.');
        }

        // tandai terbaca
        $notif->update(['status_notif' => 'terbaca']);

        // Jika notifikasi memiliki URL, gunakan langsung
        if (!empty($notif->url)) {
            return redirect($notif->url);
        }

        $pesan = strtolower($notif->pesan);
        $role = auth()->user()->roles;

        // 1) Notifikasi disposisi → route sesuai role
        if (str_contains($pesan, 'disposisi')) {
            return redirect()->route(match ($role) {
                'pimpinan'         => 'pimpinan.disposisi.index',
                'tusekwan'         => 'tusekwan.disposisi.index',
                'kabag_persidangan'=> 'kabag.persidangan.disposisi.index',
                'kabag_umum'       => 'kabag.umum.disposisi.index',
                'kabag_keuangan'   => 'kabag.keuangan.disposisi.index',
                'tusekre'          => 'tusekre.arsip_surat.index',
                default            => 'dashboard',
            });
        }

        // 2) Notifikasi revisi → TUSEKWAN harus diarahkan ke halaman verifikasi ulang
        if (str_contains($pesan, 'revisi') && $role === 'tusekwan') {
            return redirect()->route('tusekwan.surat_masuk.index');
        }

        // 3) Notifikasi revisi → TU SEKRE membuka daftar surat perlu revisi
        if (str_contains($pesan, 'revisi') && $role === 'tusekre') {
            return redirect()->route('tusekre.surat_perlu_revisi');
        }

        // 4) Surat baru → TUSEKWAN harus verifikasi
        if (str_contains($pesan, 'surat') && str_contains($pesan, 'verifikasi') && $role === 'tusekwan') {
            return redirect()->route('tusekwan.surat_masuk.index');
        }

        // fallback
        return redirect()->back();
    }



    public function readAll()
    {
        $userId = Auth::id();

        Notifikasi::where('user_id', $userId)
            ->where('status_notif', 'belum_terbaca')
            ->update(['status_notif' => 'terbaca']);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai terbaca.');
    }
}
