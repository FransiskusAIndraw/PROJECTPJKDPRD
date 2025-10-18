<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    use HasFactory;

        protected $fillable = [
        'surat_masuk_id',
        'from_user_id',
        'to_user_id',
        'catatan',
        'status',
        'tanggal_disposisi',
    ];

 public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function penerima()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function pimpinan()
    {
        return $this->belongsTo(User::class, 'pimpinan_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function suratMasuk()
{
    return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
}

public function diteruskanKepada()
{
    return $this->belongsTo(User::class, 'diteruskan_kepada');
}


}


