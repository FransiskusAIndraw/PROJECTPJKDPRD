<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $table = 'disposisi';

    protected $fillable = [
        'surat_id',
        'dari_user',
        'ke_user',
        'instruksi',
        'status_dispo',
        'tgl_disposisi',
        'posisi_terakhir',
    ];

    // Surat
    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }

    // Pengirim disposisi
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'dari_user');
    }

    // Penerima disposisi
    public function penerima()
    {
        return $this->belongsTo(User::class, 'ke_user');
    }
}
