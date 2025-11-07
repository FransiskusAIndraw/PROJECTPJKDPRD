<?php

namespace App\Http\Controllers;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SuratMasukExport;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Arsip;
use Illuminate\Support\Facades\Storage;

class TUSekreSuratController extends Controller
{
    public function index()
{
    return view('tusekre.surat_masuk.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'nomor_surat' => 'required|unique:surat_masuk,nomor_surat|max:255',
        'perihal' => 'required|string|max:255',
        'tanggal_surat' => 'required|date',
        'pengirim' => 'required|string|max:255',
        'file_surat' => 'required|file|mimes:pdf|max:2048',
    ]);

    if ($request->hasFile('file_surat')) {
        $validated['file_surat'] = $request->file('file_surat')->store('surat_masuk', 'public');
    }

    $validated['status'] = SuratMasuk::STATUS_TERKIRIM_KE_TUSEKWAN;
    $validated['status_screening'] = SuratMasuk::SCREENING_PENDING;
    $validated['created_by'] = auth()->id();

    SuratMasuk::create($validated);

    return redirect()->route('tusekre.surat_masuk.index')
        ->with('success', 'Surat berhasil diunggah ');
}

public function search(Request $request)
{
    $query = $request->input('q');

    $suratMasuk = \App\Models\SuratMasuk::query()
        ->when($query, function ($q) use ($query) {
            $q->where('nomor_surat', 'like', "%{$query}%")
              ->orWhere('perihal', 'like', "%{$query}%")
              ->orWhere('pengirim', 'like', "%{$query}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('tusekre.search_surat', compact('suratMasuk', 'query'));
}

public function suratPerluRevisi()
{
    $suratPerluRevisi = SuratMasuk::where('status', SuratMasuk::STATUS_PERLU_REVISI)
        ->where('created_by', Auth::id())
        ->orderByDesc('updated_at')
        ->paginate(10);

    return view('tusekre.surat-perlu-revisi', compact('suratPerluRevisi'));
}

public function editRevisi($id)
{
    $surat = SuratMasuk::findOrFail($id);

    // Pastikan hanya pembuat surat yang bisa mengedit revisinya
    if ($surat->created_by !== Auth::id()) {
        return back()->with('error', 'Anda tidak berhak merevisi surat ini.');
    }

    return view('tusekre.surat_masuk.edit', compact('surat'));
}


public function updateRevisi(Request $request, $id)
{
    $surat = SuratMasuk::findOrFail($id);

    if ($surat->created_by !== Auth::id()) {
        return back()->with('error', 'Anda tidak berhak memperbarui surat ini.');
    }

    $validated = $request->validate([
        'nomor_surat' => 'required|max:255|unique:surat_masuk,nomor_surat,' . $surat->id,
        'perihal' => 'required|string|max:255',
        'tanggal_surat' => 'required|date',
        'pengirim' => 'required|string|max:255',
        'file_surat' => 'nullable|file|mimes:pdf|max:2048',
    ]);

    // Jika file baru diupload, ganti file lama
    if ($request->hasFile('file_surat')) {
        $validated['file_surat'] = $request->file('file_surat')->store('surat_masuk', 'public');
    } else {
        $validated['file_surat'] = $surat->file_surat;
    }

    // Update isi surat
    $surat->update($validated);

    // Reset status agar dikirim ulang ke TU Sekwan
    $surat->markKirimUlangSetelahRevisi(Auth::id());



    return redirect()->route('tusekre.surat_perlu_revisi')
        ->with('success', 'Surat berhasil diperbaiki dan dikirim ulang ke TU Sekwan.');
}

        public function arsipkan($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        // Cegah arsip ganda
        if (Arsip::where('surat_id', $surat->id)->exists()) {
            return back()->with('error', 'Surat ini sudah diarsipkan sebelumnya.');
        }

        // Simpan data arsip baru
        Arsip::create([
            'surat_id' => $surat->id,
            'lokasi_file' => $surat->file_surat,
            'format_arsip' => 'pdf',
            'periode' => now()->format('Y-m'),
        ]);

        // Update status surat menjadi "arsipkan"
        $surat->update(['status' => SuratMasuk::STATUS_DIARSIPKAN]);

        return back()->with('success', 'Surat berhasil diarsipkan dan status diperbarui menjadi "arsipkan".');
    }

    public function arsipIndex(Request $request)
    {
        $periode = $request->input('periode', 'all');

        $query = SuratMasuk::query();

        // Filter berdasarkan tanggal_surat sesuai periode
        switch ($periode) {
            case '1_week':
                $query->where('tanggal_surat', '>=', Carbon::now()->subWeek()->toDateString());
                break;
            case '1_month':
                $query->where('tanggal_surat', '>=', Carbon::now()->subMonth()->toDateString());
                break;
            case '3_months':
                $query->where('tanggal_surat', '>=', Carbon::now()->subMonths(3)->toDateString());
                break;
            case '6_months':
                $query->where('tanggal_surat', '>=', Carbon::now()->subMonths(6)->toDateString());
                break;
            case '1_year':
                $query->where('tanggal_surat', '>=', Carbon::now()->subYear()->toDateString());
                break;
            case 'all':
            default:
                // no date filter
                break;
        }

        $suratMasuk = $query->orderBy('tanggal_surat', 'desc')->paginate(10);
        return view('tusekre.arsip_surat', compact('suratMasuk'));
    }

    /**
     * Export Excel sesuai periode (dari query string ?periode=...)
     */
public function exportExcel(Request $request)
{
    $periode = $request->query('periode', 'all');
    return Excel::download(new SuratMasukExport($periode), 'arsip_surat_' . $periode . '.xlsx');
}
}