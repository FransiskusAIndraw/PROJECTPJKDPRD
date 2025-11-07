@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Penambahan Akun</h2>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan Error --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Penambahan Akun --}}
    <form action="{{ route('admin.store_akun') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium text-gray-700 mb-1">Nama Pengguna</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Masukkan nama lengkap" 
                required
            >
        </div>

        <div>
            <label for="email" class="block font-medium text-gray-700 mb-1">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email') }}"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="contoh@email.com" 
                required
            >
        </div>

        <div>
            <label for="roles" class="block font-medium text-gray-700 mb-1">Role Pengguna</label>
            <select 
                name="roles" 
                id="roles" 
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"
                required
            >
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="tusekre">TU Sekretariat</option>
                <option value="tusekwan">TU Sekwan</option>
                <option value="pimpinan">Pimpinan</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div>
            <label for="password" class="block font-medium text-gray-700 mb-1">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Minimal 8 karakter" 
                required
            >
        </div>

        <div>
            <label for="password_confirmation" class="block font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation"
                class="w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" 
                placeholder="Ulangi password" 
                required
            >
        </div>

        <div class="flex items-center justify-between pt-4">
            <a href="{{ route('admin.kelola_pengguna') }}" 
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                ← Kembali
            </a>
            <button 
                type="submit" 
                class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">
                Tambah Akun
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelector('#sidebar-penambahan-akun')?.classList.add('bg-blue-100', 'text-blue-600', 'font-semibold');
</script>
@endsection
