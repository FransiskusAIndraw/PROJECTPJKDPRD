@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Kelola Akun</h2>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter dan Pencarian --}}
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <input 
            type="text" 
            id="searchInput" 
            placeholder="Cari berdasarkan nama pengguna..." 
            class="flex-grow border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"
        >

        <select id="roleFilter" class="border border-gray-300 rounded-md p-2">
            <option value="">Semua Role</option>
            <option value="Admin">Admin</option>
            <option value="Beta">Beta</option>
            <option value="Staff">Staff</option>
            <option value="User">User</option>
            <option value="TU Sekretariat">TU Sekretariat</option>
            <option value="TU Sekwan">TU Sekwan</option>
            <option value="Pimpinan">Pimpinan</option>
        </select>

        <div class="flex items-center gap-2">
            <label for="rowsPerPage" class="font-medium text-gray-700">Baris:</label>
            <select id="rowsPerPage" class="border border-gray-300 rounded-md p-2">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
    </div>

    {{-- Tabel Daftar Pengguna --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-md">
            <thead class="bg-blue-700 text-white">
                <tr class="text-left">
                    <th class="px-4 py-2 border-b">ID Akun</th>
                    <th class="px-4 py-2 border-b">Nama Pengguna</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Role</th>
                    <th class="px-4 py-2 border-b text-center">Hapus Akun</th>
                    <th class="px-4 py-2 border-b text-center">Edit Role</th>
                </tr>
            </thead>
            <tbody id="userTable">
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 border-b">
                        <td class="px-4 py-2">{{ $user->id }}</td>
                        <td class="px-4 py-2">{{ $user->name }}</td>
                        <td class="px-4 py-2">{{ $user->email }}</td>
                        <td class="px-4 py-2">{{ $user->roles }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.hapus_akun', $user->id) }}" 
                               class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                                Hapus
                            </a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('admin.edit_role', $user->id) }}" 
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                                Edit
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center items-center mt-4 gap-3">
        <button id="prevPage" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">Prev</button>
        <span id="pageInfo" class="text-gray-700"></span>
        <button id="nextPage" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300">Next</button>
    </div>
</div>

<script>
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const rowsPerPageSelect = document.getElementById('rowsPerPage');
    const userTable = document.getElementById('userTable');
    const rows = Array.from(userTable.querySelectorAll('tr'));
    let rowsPerPage = parseInt(rowsPerPageSelect.value);
    let currentPage = 1;

    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageInfo = document.getElementById('pageInfo');

    function filterRows() {
        const searchValue = searchInput.value.toLowerCase();
        const selectedRole = roleFilter.value.toLowerCase();

        return rows.filter(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const role = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const matchesSearch = name.includes(searchValue);
            const matchesRole = selectedRole === '' || role.includes(selectedRole);
            return matchesSearch && matchesRole;
        });
    }

    function renderTable() {
        const filteredRows = filterRows();
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage);

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach(r => (r.style.display = 'none'));
        filteredRows.slice(start, end).forEach(r => (r.style.display = ''));

        pageInfo.textContent = filteredRows.length
            ? `Halaman ${currentPage} dari ${totalPages}`
            : 'Tidak ada data ditemukan';
    }

    searchInput.addEventListener('input', () => { currentPage = 1; renderTable(); });
    roleFilter.addEventListener('change', () => { currentPage = 1; renderTable(); });
    rowsPerPageSelect.addEventListener('change', () => { 
        rowsPerPage = parseInt(rowsPerPageSelect.value);
        currentPage = 1;
        renderTable();
    });
    prevPageBtn.addEventListener('click', () => { currentPage--; renderTable(); });
    nextPageBtn.addEventListener('click', () => { currentPage++; renderTable(); });

    renderTable();
</script>
@endsection
