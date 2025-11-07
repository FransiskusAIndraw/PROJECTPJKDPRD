@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Revisi Surat Masuk</h2>

    {{-- Pesan notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Form revisi surat --}}
    <form action="{{ route('tusekre.surat_masuk.update_revisi', $surat->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-6">
        @csrf
        @method('PUT')

        {{-- Kolom kiri --}}
        <div>
            <label class="block mb-2 font-medium">Nomor Surat</label>
            <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}"
                class="w-full border border-gray-300 rounded p-2" required>

            <label class="block mt-4 mb-2 font-medium">Perihal</label>
            <input type="text" name="perihal" value="{{ old('perihal', $surat->perihal) }}"
                maxlength="255"
                class="w-full border border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500" required>
            <p id="charCount" class="text-xs text-gray-500 mt-1">0 / 255 karakter</p>

            <label class="block mt-4 mb-2 font-medium">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}"
                class="w-full border border-gray-300 rounded p-2" required>

            <label class="block mt-4 mb-2 font-medium">Asal Surat</label>
            <input type="text" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}"
                class="w-full border border-gray-300 rounded p-2" required>
        </div>

        {{-- Kolom kanan --}}
        <div class="flex flex-col justify-center items-center border-2 border-dashed border-gray-300 rounded-lg p-6">
            <p class="font-semibold mb-2">Upload Ulang Surat (PDF)</p>
            <input type="file" name="file_surat" accept="application/pdf">
            @if ($surat->file_surat)
                <p class="text-xs text-gray-500 mt-2">
                    File saat ini: 
                    <a href="{{ asset('storage/' . $surat->file_surat) }}" target="_blank" class="text-blue-600 underline">
                        Lihat File
                    </a>
                </p>
            @endif

            <div class="mt-6 w-full">
                <label class="block mb-2 font-medium text-sm text-gray-700">Catatan dari TU Sekwan</label>
                <textarea readonly
                    class="w-full border border-gray-300 rounded p-2 bg-gray-100 text-gray-700 cursor-not-allowed">{{ $surat->catatan_tusekwan ?? 'Tidak ada catatan revisi.' }}</textarea>
            </div>
        </div>

        {{-- Tombol Submit --}}
        <div class="col-span-2 flex justify-end mt-4">
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
                Kirim Ulang ke TU Sekwan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const perihalInput = document.querySelector("[name='perihal']");
    const charCount = document.getElementById("charCount");

    if (perihalInput && charCount) {
        perihalInput.addEventListener("input", () => {
            const length = perihalInput.value.length;
            charCount.textContent = `${length} / 255 karakter`;
            charCount.classList.toggle("text-red-600", length > 255);
        });
        charCount.textContent = `${perihalInput.value.length} / 255 karakter`;
    }
});
</script>
@endsection
