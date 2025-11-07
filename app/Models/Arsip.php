<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arsip extends Model
{
    use HasFactory;

    protected $table = 'arsip';

    protected $fillable = [
        'surat_id',
        'lokasi_file',
        'format_arsip',
        'periode',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }
}
