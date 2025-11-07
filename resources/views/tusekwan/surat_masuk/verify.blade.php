@extends('layouts.tusekwan')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-semibold mb-4">Verifikasi Surat Masuk</h2>

    <div class="grid grid-cols-2 gap-6">
        {{-- Informasi Surat --}}
        <div>
            <p><strong>Nomor Surat:</strong> {{ $surat->nomor_surat }}</p>
            <p><strong>Perihal:</strong> {{ $surat->perihal }}</p>
            <p><strong>Tanggal Surat:</strong> {{ $surat->tanggal_surat->format('d M Y') }}</p>
            <p><strong>Asal Surat:</strong> {{ $surat->pengirim }}</p>
            <p><strong>Status Saat Ini:</strong> 
                <span class="px-2 py-1 text-xs rounded 
                    @if($surat->status === 'terkirim_ke_tusekwan') bg-yellow-100 text-yellow-800
                    @elseif($surat->status === 'menunggu_verifikasi') bg-blue-100 text-blue-800
                    @elseif($surat->status === 'perlu_revisi') bg-red-100 text-red-800
                    @elseif($surat->status === 'terverifikasi') bg-green-100 text-green-800
                    @endif">
                    {{ \App\Models\SuratMasuk::statusLabel($surat->status) }}
                </span>
            </p>

            <div class="mt-4">
                <a href="{{ asset('storage/' . $surat->file_surat) }}" 
                   target="_blank" 
                   class="text-blue-600 hover:underline">📄 Lihat File Surat (PDF)</a>
            </div>
        </div>

        {{-- Form Verifikasi --}}
        <form action="{{ route('tusekwan.surat_masuk.update', $surat->id) }}" method="POST" class="bg-gray-50 p-4 rounded border">
            @csrf
            @method('PUT')

            {{-- Catatan --}}
            <label class="block mb-2 font-medium">Catatan Revisi</label>
            <textarea 
                name="catatan_tusekwan" 
                id="catatan_tusekwan"
                class="w-full border-gray-300 rounded p-2"
                rows="4"
                placeholder="Tulis alasan jika surat ditolak..."
                disabled
            ></textarea>

            {{-- Status --}}
            <label class="block mt-4 mb-2 font-medium">Hasil Verifikasi</label>
            <select name="status" id="status_select" class="w-full border rounded p-2" required>
                <option value="" disabled selected>-- Hasil Verifikasi --</option>
                <option value="disetujui">✔️ Disetujui (Terverifikasi)</option>
                <option value="ditolak">❌ Ditolak (Perlu Revisi)</option>
            </select>

            <div class="flex justify-end mt-6 gap-2">
                <a href="{{ route('tusekwan.surat_masuk.index') }}" 
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Kembali</a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-700 text-white rounded hover:bg-blue-800">
                    Simpan Verifikasi
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Logika interaktif --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status_select');
    const catatanField = document.getElementById('catatan_tusekwan');

    function updateCatatanField() {
        const selected = statusSelect.value;

        if (selected === 'ditolak') {
            catatanField.disabled = false;
            catatanField.required = true;
        } else {
            catatanField.disabled = true;
            catatanField.required = false;
            catatanField.value = '';
        }
    }

    statusSelect.addEventListener('change', updateCatatanField);
    updateCatatanField(); // Jalankan saat halaman load pertama kali
});
</script>
@endsection
