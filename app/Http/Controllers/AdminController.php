<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'disposisiAktif'   => \App\Models\Disposisi::where('status_dispo', 'pending')->count(),
            'suratMasuk'  => \App\Models\SuratMasuk::count(),
        ]);    
    }

    public function kelolaPengguna()
    {
        $users = User::all();  // Mengambil semua pengguna
        return view('admin.kelola-pengguna', compact('users'));
    }

    // Menghapus akun pengguna
    public function hapusAkun($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.kelola_pengguna')->with('success', 'Akun berhasil dihapus');
    }

    public function penambahanAkun()
    {
        // Logic untuk menampilkan form penambahan akun
        return view('admin.penambahan-akun');
    }
    
    public function storeAkun(Request $request)
    {
        // Validasi data yang dimasukkan
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        // Membuat akun baru
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->roles = $validatedData['roles'];
        $user->password = bcrypt($validatedData['password']);

        // Simpan data ke database
        if ($user->save()) {
            return redirect()
                ->route('admin.kelola_pengguna')
                ->with('success', 'Akun berhasil ditambahkan.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Gagal menambahkan akun. Silakan coba lagi.');
        }
    }
    public function editRole($id)
    {
        // Ambil pengguna berdasarkan ID
        $user = User::find($id);

        if ($user && $user->id == auth()->user()->id) {
            return redirect()->route('admin.kelola_pengguna')->with('error', 'Anda tidak dapat mengedit akun Anda sendiri.');
        }

        if ($user) {
            return view('admin.edit-role', compact('user'));  // Tampilkan form edit dengan data pengguna
        }

        return redirect()->route('admin.kelola_pengguna')->with('error', 'Pengguna tidak ditemukan');
        }

    public function updateRole(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|string',  // Ganti role menjadi roles
            'password' => 'nullable|min:8|confirmed',  // Validasi password jika ada perubahan
        ]);

        // Ambil pengguna berdasarkan ID
        $user = User::find($id);

        if ($user) {
            // Update data pengguna
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->roles = $validatedData['roles'];  // Ganti role menjadi roles

            // Jika password diubah, enkripsi dan simpan
            if ($request->filled('password')) {
                $user->password = bcrypt($validatedData['password']);
            }

            // Simpan perubahan
            $user->save();

            // Redirect setelah update berhasil
            return redirect()->route('admin.kelola_pengguna')->with('success', 'Data akun berhasil diperbarui');
        }

        return redirect()->route('admin.kelola_pengguna')->with('error', 'Pengguna tidak ditemukan');
    }
}