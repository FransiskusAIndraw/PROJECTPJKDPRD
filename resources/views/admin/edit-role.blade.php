@extends('layouts.admin')

@section('content')
    <div class="p-6">
        <h2 class="text-xl font-semibold">Edit Akun Pengguna</h2>

        <form action="{{ route('admin.update_role', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="roles" class="block text-gray-700">Role</label>
                <select name="roles" class="p-2 border border-gray-300 rounded">
                    <option value="admin" {{ old('roles', $user->roles) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="tusekre" {{ old('roles', $user->roles) == 'tusekre' ? 'selected' : '' }}>TU Sekretariat</option>
                    <option value="tusekwan" {{ old('roles', $user->roles) == 'tusekwan' ? 'selected' : '' }}>TU Sekwan</option>
                    <option value="pimpinan" {{ old('roles', $user->roles) == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="staff" {{ old('roles', $user->roles) == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="p-2 border border-gray-300 rounded">
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Update Akun</button>
        </form>
    </div>
@endsection
