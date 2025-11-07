<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\Arsip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KabagDisposisiController extends Controller
{
    /**
     * Tampilkan daftar disposisi untuk Kabag (role spesifik).
     */
    public function index()
{
    $user = Auth::user();
    $role = $user->roles; // ex: 'kabag_keuangan'

    // 1) Coba pola A: disposisi ditujukan langsung ke user (ke_user = user id)
    $byUserId = Disposisi::with(['surat', 'pengirim'])
        ->where('ke_user', $user->id)
        ->where(function($q) {
            $q->where('status_dispo', 'pending')->orWhereNull('status_dispo');
        })
        ->orderByDesc('tgl_disposisi')
        ->get();

    if ($byUserId->isNotEmpty()) {
        $disposisis = $byUserId;
    } else {
        // 2) Jika kosong, coba pola B: disposisi.posisi_terakhir = 'kabag' 
        //    dan surat.diteruskan_ke_role = nama role kabag
        $disposisis = Disposisi::with(['surat', 'pengirim'])
            ->where('posisi_terakhir', 'kabag')
            ->where(function($q){
                $q->where('status_dispo', 'pending')->orWhereNull('status_dispo');
            })
            ->whereHas('surat', function ($q) use ($role) {
                $q->where('diteruskan_ke_role', $role);
            })
            ->orderByDesc('tgl_disposisi')
            ->get();
    }

    return view('kabag.disposisi.index', compact('disposisis'));
}


    /**
     * Tampilkan detail disposisi.
     */
    public function show($id)
    {
        $disposisi = Disposisi::with(['surat', 'pengirim', 'penerima'])->findOrFail($id);

        // safety: jika disposisi disimpan berdasar role, cek role; jika berdasar user id, cek ke_user
        $user = Auth::user();
        $role = $user->roles;

        // contoh cek: disposisi ditujukan ke role tertentu (surat.diteruskan_ke_role)
        if ($disposisi->posisi_terakhir !== 'kabag'
            || ($disposisi->surat->diteruskan_ke_role ?? '') !== $role) {
            abort(403, 'Anda tidak berhak melihat disposisi ini.');
        }

        // Opsi: jika kamu menyimpan ke_user sebagai user id, ganti pengecekan di atas:
        // if ($disposisi->ke_user !== $user->id) { abort(403); }

        return view('kabag.disposisi.show', compact('disposisi'));
    }

    /**
     * Tandai disposisi selesai dan arsipkan surat + disposisi ke tabel arsip.
     */
    public function selesai(Request $request, $id)
    {
        $user = Auth::user();

        $disposisi = Disposisi::with('surat')->findOrFail($id);

        // Permission: pastikan disposisi memang untuk bidang/kabag ini
        $role = $user->roles;
        if (($disposisi->surat->diteruskan_ke_role ?? '') !== $role) {
            // jika kamu pakai ke_user user-id, cek: if ($disposisi->ke_user !== $user->id) { ... }
            return redirect()->back()->with('error', 'Anda tidak berhak memproses disposisi ini.');
        }

        $request->validate([
            'catatan_kabag' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($disposisi, $user, $request) {
            // update disposisi status
            $disposisi->update([
                'status_dispo' => 'selesai',
                'posisi_terakhir' => 'selesai',
                // simpan catatan lokal disposisi jika kolom ada
                'catatan_kabag' => $request->input('catatan_kabag'),
            ]);

            // update surat status -> diarsipkan (final)
            $surat = $disposisi->surat;
            $surat->update([
                'status' => SuratMasuk::STATUS_DIARSIPKAN,
            ]);

            // insert ke tabel arsip
            Arsip::create([
                'surat_id' => $surat->id,
                'disposisi_id' => $disposisi->id,
                'arsipkan_oleh' => $user->id,
                'arsipkan_oleh_role' => $user->roles,
                'lokasi_file' => $surat->file_surat ?? null,
                // Simpan snapshot data surat/disposisi supaya arsip lengkap:
                'nomor_surat' => $surat->nomor_surat,
                'tanggal_surat' => $surat->tanggal_surat,
                'pengirim' => $surat->pengirim,
                'perihal' => $surat->perihal,
                'instruksi' => $disposisi->instruksi,
                'file_surat' => $surat->file_surat,
            ]);
        });

        return redirect()->route('kabag.' . $this->bidangSlug() . '.disposisi.index')
            ->with('success', 'Disposisi ditandai selesai dan surat berhasil diarsipkan.');
    }

    /**
     * helper: slug bidang dari user role, misal 'kabag_keuangan' -> 'keuangan'
     */
    protected function bidangSlug()
    {
        $role = Auth::user()->roles ?? '';
        return match($role) {
            'kabag_keuangan' => 'keuangan',
            'kabag_persidangan' => 'persidangan',
            'kabag_umum' => 'umum',
            default => 'umum',
        };
    }
}
