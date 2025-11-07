<?php

namespace App\Http\Controllers;
use App\Helpers\NotifHelper;
use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Storage;

class TUSekwanSuratController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::whereIn('status', [
                SuratMasuk::STATUS_DRAFT,
                SuratMasuk::STATUS_TERKIRIM_KE_TUSEKWAN,
                SuratMasuk::STATUS_MENUNGGU_VERIFIKASI,
            ])
            ->where('status_screening', SuratMasuk::SCREENING_PENDING)
            ->orderByDesc('tanggal_surat')
            ->get();

        return view('tusekwan.surat_masuk.index', compact('suratMasuk'));
    }

    public function edit($id)
    {
        $surat = SuratMasuk::findOrFail($id);
        // jika surat masih "terkirim", ubah dulu jadi "menunggu verifikasi"
        if ($surat->status === SuratMasuk::STATUS_TERKIRIM_KE_TUSEKWAN) {
            $surat->markMenungguVerifikasi();
        }
        return view('tusekwan.surat_masuk.verify', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'catatan_tusekwan' => 'nullable|string|max:500',
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $surat = SuratMasuk::findOrFail($id);

        if ($request->status === 'disetujui') {
            // Verifikasi disetujui
            $surat->markTerverifikasi($request->catatan_tusekwan, auth()->id());
            $message = 'Surat berhasil diteruskan ke pimpinan.';
        } else {
            // Verifikasi ditolak -> kembali ke TU Sekre untuk revisi
            $surat->markPerluRevisi($request->catatan_tusekwan, auth()->id());
            $message = 'Surat dikembalikan ke TU Sekretariat untuk revisi.';
            NotifHelper::send($surat->created_by, 'Surat Anda dikembalikan untuk revisi.', route('tusekre.surat_perlu_revisi'));

        }
        return redirect()->route('tusekwan.surat_masuk.index')->with('success', $message);
    }

    public function sekwan_make_disposisi(Request $request)
    {
        $validated = $request->validate([
            'surat_id' => 'required|exists:surat_masuk,id',
            'instruksi' => 'required|string',
        ]);

        Disposisi::create([
            'surat_id' => $validated['surat_id'],
            'dari_user' => auth()->id(),
            'ke_user' => User::where('roles','pimpinan')->first()->id,
            'instruksi' => $validated['instruksi'],
            'status_dispo' => 'pending',
            'posisi_terakhir' => 'pimpinan',
        ]);

        SuratMasuk::find($validated['surat_id'])
            ->update(['status' => SuratMasuk::STATUS_DIDISPOSISIKAN_KE_PIMPINAN]);

        return back()->with('success','Surat berhasil didisposisikan ke Pimpinan');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $suratMasuk = SuratMasuk::query()
            ->when($query, function ($q) use ($query) {
                $q->where('nomor_surat', 'like', "%{$query}%")
                ->orWhere('perihal', 'like', "%{$query}%")
                ->orWhere('pengirim', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('tusekwan.cari_surat', compact('suratMasuk', 'query'));
    }
}
