@csrf
<div class="mb-4">
    <label for="status_screening" class="block text-sm font-medium text-gray-700 mb-2">Status Screening</label>
    <select id="status_screening" name="status_screening" class="border-gray-300 rounded-lg w-full p-2">
        <option value="pending" {{ $surat->status_screening == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $surat->status_screening == 'approved' ? 'selected' : '' }}>Disetujui</option>
        <option value="rejected" {{ $surat->status_screening == 'rejected' ? 'selected' : '' }}>Ditolak</option>
    </select>
</div>

<div class="mb-4">
    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (opsional)</label>
    <textarea id="catatan" name="catatan" rows="3" class="border-gray-300 rounded-lg w-full p-2"
        placeholder="Tambahkan catatan atau alasan...">{{ old('catatan', $surat->catatan ?? '') }}</textarea>
</div>

<div class="flex justify-end space-x-2">
    <a href="{{ route('tusekwan.screening.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
        Batal
    </a>
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Simpan
    </button>
</div>
