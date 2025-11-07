<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TUSekwanDisposisiController extends Controller
{
    /**
     * Daftar surat yang siap didisposisikan ke Pimpinan
     */
    public function index()
    {
        // Surat yang akan dikirim ke pimpinan
        $suratUntukPimpinan = SuratMasuk::where('status', SuratMasuk::STATUS_TERVERIFIKASI)->get();

        // Surat yang sudah dikembalikan pimpinan → siap finalisasi TU Sekwan
        $suratDariPimpinan = SuratMasuk::where('status', SuratMasuk::STATUS_DITERIMA_SEKWAN)->get();

        return view('tusekwan.disposisi.index', compact('suratUntukPimpinan', 'suratDariPimpinan'));
    }

    /**
     * Form pembuatan disposisi oleh TU Sekwan
     */
    public function create($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // Ambil user yang role-nya pimpinan
        $pimpinan = User::where('roles', 'pimpinan')->get();

        return view('tusekwan.disposisi.create', compact('surat', 'pimpinan'));
    }

    /**
     * Simpan disposisi & kirim ke pimpinan
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'ke_user' => 'required|exists:users,id',
            'instruksi' => 'required|string|max:1000',
        ]);

        Disposisi::create([
            'surat_id' => $id,
            'dari_user' => Auth::id(),
            'ke_user' => $validated['ke_user'],
            'instruksi' => "Oleh SEKWAN:\n" . $validated['instruksi'], 
            'status_dispo' => 'pending',
            'tgl_disposisi' => now(),
            'posisi_terakhir' => 'pimpinan',
        ]);

        // Update status surat menjadi 'didisposisikan ke pimpinan'
        $surat = SuratMasuk::find($id);
        $surat->update([
            'status' => SuratMasuk::STATUS_DIDISPOSISIKAN_KE_PIMPINAN
        ]);

        $penerima = User::find($validated['ke_user'])->name;

        return redirect()->route('tusekwan.disposisi.index')
            ->with('success', "Disposisi berhasil dikirim ke {$penerima}.");
    }

    public function finalForm($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        $disposisiTerbaru = $surat->disposisis()->latest()->first();

        return view('tusekwan.disposisi.final', compact('surat', 'disposisiTerbaru'));
    }

    public function finalSubmit(Request $request, $id)
    {
        $request->validate([
            'instruksi_final' => 'required|string|max:1000',
            'tujuan' => 'required|in:kabag_persidangan,kabag_keuangan,kabag_umum,tusekre',
        ]);

        $surat = SuratMasuk::findOrFail($id);
        $disposisi = $surat->disposisis()->latest()->first();

        // Tambahkan instruksi tindak lanjut TU Sekwan
        $disposisi->update([
            'instruksi' => $disposisi->instruksi . "\n\nOleh SEKWAN (Final):\n" . $request->instruksi_final,
        ]);

        // Jika diteruskan ke Kabag tertentu
        if (in_array($request->tujuan, ['kabag_persidangan', 'kabag_keuangan', 'kabag_umum'])) {

            $surat->update([
                'status' => SuratMasuk::STATUS_DITERUSKAN_KE_KABAG,
                'diteruskan_ke_role' => $request->tujuan,
            ]);

            $disposisi->update(['posisi_terakhir' => 'kabag', 'status_dispo' => 'pending']);
        }
        // Jika langsung ke TU Sekre
        else {  // <-- error ini muncul kalau sebelumnya ada tanda } atau ; yang hilang
            $surat->update([
                'status' => SuratMasuk::STATUS_DITERUSKAN_KE_TUSEKRE,
                'diteruskan_ke_role' => 'tusekre',
            ]);
            $disposisi->update(['posisi_terakhir' => 'tusekre', 'status_dispo' => 'pending']);
        }

        return redirect()->route('tusekwan.disposisi.index')
            ->with('success', 'Disposisi final berhasil dikirim.');
    }

}
