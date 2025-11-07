<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    // Untuk menampilkan halaman notifikasi (opsional)
    public function index()
    {
        $user = Auth::user();
        $notifs = Notifikasi::where('user_id', $user->id)
                    ->orderByDesc('created_at')
                    ->paginate(20);
        return view('notifikasi.index', compact('notifs'));
    }

    // Tandai 1 notifikasi sebagai terbaca dan redirect ke target
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notif = Notifikasi::where('id', $id)->where('user_id', $user->id)->first();
        if (! $notif) {
            return redirect()->back()->with('error','Notifikasi tidak ditemukan.');
        }

        // tandai terbaca
        $notif->update(['status_notif' => 'terbaca']);

        // jika payload ingin menyimpan target url, bisa simpan sebagai JSON di kolom pesan
        // di contoh ini kita mengandalkan string pesan => jika butuh redirect spesifik, simpan tambahan kolom target_url
        // contoh: kalau pesan berisi "surat:123" kita parse untuk redirect
        if (preg_match('/surat:(\d+)/', $notif->pesan, $m)) {
            $suratId = $m[1];
            return redirect()->route('tusekwan.surat_masuk.edit', $suratId);
        }

        return redirect()->back();
    }

    public function markAllRead()
    {
        $user = Auth::user();
        Notifikasi::where('user_id', $user->id)->update(['status_notif' => 'terbaca']);
        return redirect()->back();
    }
}
