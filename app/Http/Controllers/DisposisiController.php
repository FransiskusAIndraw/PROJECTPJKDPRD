<?php

namespace App\Http\Controllers;

use app\Models\Disposisi;
use app\Models\SuratMasuk;
use app\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DisposisiController extends Controller
{
    public function index()
    {
        $disposisis = Disposisi::with(['surat', 'pengirim', 'penerima'])->get();
        return view('admin.disposisi.index', compact('disposisis'));
    }

    public function create($surat_id)
    {
        $surat = SuratMasuk::findOrFail($surat_id);
        $users = User::whereIn('roles', ['pimpinan', 'staff'])->get(); // target roles
        return view('admin.disposisi.create', compact('surat', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'to_user_id' => 'required|exists:users,id',
            'catatan' => 'nullable|string|max:500',
        ]);

        Disposisi::create([
            'surat_masuk_id' => $request->surat_masuk_id,
            'from_user_id' => Auth::id(),
            'to_user_id' => $request->to_user_id,
            'catatan' => $request->catatan,
        ]);

        return redirect()->back()->with('success', 'Disposisi berhasil dikirim.');
    }

    public function show($id)
    {
        $disposisi = Disposisi::with(['surat', 'pengirim', 'penerima'])->findOrFail($id);
        return view('admin.disposisi.show', compact('disposisi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $disposisi = Disposisi::findOrFail($id);
        $disposisi->update(['status' => $request->status]);
        return back()->with('success', 'Status disposisi diperbarui.');
    }
}
