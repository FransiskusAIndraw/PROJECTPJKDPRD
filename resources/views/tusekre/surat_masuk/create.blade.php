@extends('layouts.tusekre')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Input Surat Masuk</h2>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tusekre.surat_masuk.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-2 gap-6">
        @csrf

        <div>
            <label class="block mb-2 font-medium">Nomor Surat</label>
            <input type="text" name="nomor_surat" class="w-full border border-gray-300 rounded p-2" placeholder="Masukkan nomor surat" required>

            <label for="perihal" class="block mt-4 mb-2 font-medium">Perihal Surat</label>
            <input type="text" name="perihal" id="perihal"
                maxlength="255"
                class="w-full border border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="Masukkan perihal surat (max 255 karakter)" required>
            <p id="charCount" class="text-xs text-gray-500 mt-1">0 / 255 karakter</p>

            <label class="block mt-4 mb-2 font-medium">Tanggal Surat</label>
            <input type="date" name="tanggal_surat" class="w-full border border-gray-300 rounded p-2" required>

            <label class="block mt-4 mb-2 font-medium">Asal Surat</label>
            <input type="text" name="pengirim" class="w-full border border-gray-300 rounded p-2" placeholder="Masukkan asal surat" required>
        </div>

        <div class="flex flex-col justify-center items-center border-2 border-dashed border-gray-300 rounded-lg p-6">
            <label class="font-semibold mb-2">Upload Surat (PDF)</label>
            <input type="file" name="file_surat" accept="application/pdf" required>
        </div>

        <div class="col-span-2 flex justify-end">
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800">
                Submit
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const perihalInput = document.getElementById("perihal");
    const charCount = document.getElementById("charCount");

    perihalInput.addEventListener("input", () => {
        const length = perihalInput.value.length;
        charCount.textContent = `${length} / 255 karakter`;

        if (length > 255) {
            charCount.classList.remove("text-gray-500");
            charCount.classList.add("text-red-600");
        } else {
            charCount.classList.remove("text-red-600");
            charCount.classList.add("text-gray-500");
        }
    });
});
</script>
@endsection
