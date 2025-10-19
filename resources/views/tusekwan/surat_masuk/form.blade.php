<div class="space-y-4">
    <div>
        <label for="status" class="block font-medium">Status Screening</label>
        <select name="status_screening" id="status" class="border rounded px-3 py-2 w-full">
            <option value="pending" {{ $surat->status_screening == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ $surat->status_screening == 'approved' ? 'selected' : '' }}>Disetujui</option>
            <option value="rejected" {{ $surat->status_screening == 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </div>
    <div>
        <label for="catatan" class="block font-medium">Catatan</label>
        <textarea name="catatan" id="catatan" class="border rounded px-3 py-2 w-full">{{ old('catatan', $surat->catatan ?? '') }}</textarea>
    </div>
</div>
