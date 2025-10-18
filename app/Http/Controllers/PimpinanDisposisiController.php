<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PimpinanDisposisiController extends Controller
{
    /**
     * Display a listing of disposisi made or received by pimpinan.
     */
    public function index()
    {
        $user = Auth::user();

        $disposisis = Disposisi::with(['suratMasuk', 'diteruskanKepada'])
            ->where('user_id', $user->id)
            ->orWhere('diteruskan_kepada', $user->id)
            ->latest()
            ->get();

        return view('pimpinan.disposisi.index', compact('disposisis'));
    }

    /**
     * Show form to create a new disposisi (forward surat to staff/pimpinan).
     */
    public function create()
    {
        $suratMasuks = SuratMasuk::whereDoesntHave('disposisis', function ($q) {
            $q->where('status', '!=', 'selesai');
        })->get();

        $staffs = User::whereIn('roles', ['staff', 'pimpinan'])->get();

        return view('pimpinan.disposisi.create', compact('suratMasuks', 'staffs'));
    }

    /**
     * Store a new disposisi (forward surat with notes).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
            'diteruskan_kepada' => 'required|exists:users,id',
            'catatan' => 'required|string|max:1000',
        ]);

        Disposisi::create([
            'surat_masuk_id' => $validated['surat_masuk_id'],
            'user_id' => Auth::id(),
            'diteruskan_kepada' => $validated['diteruskan_kepada'],
            'catatan' => $validated['catatan'],
            'status' => 'proses',
        ]);

        return redirect()->route('pimpinan.disposisi.index')
            ->with('success', 'Surat berhasil didisposisikan.');
    }

    /**
     * Show detail of a disposisi (surat, notes, status, recipient).
     */
    public function show(string $id)
    {
        $disposisi = Disposisi::with(['suratMasuk', 'diteruskanKepada'])->findOrFail($id);
        return view('pimpinan.disposisi.show', compact('disposisi'));
    }

    /**
     * Mark disposisi as selesai.
     */
    public function update(Request $request, string $id)
    {
        $disposisi = Disposisi::findOrFail($id);
        $disposisi->update(['status' => 'selesai']);

        return redirect()->back()->with('success', 'Disposisi telah diselesaikan.');
    }
}
