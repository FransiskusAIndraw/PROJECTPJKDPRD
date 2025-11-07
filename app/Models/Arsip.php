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
        'disposisi_id',
        'arsipkan_oleh',
        'arsipkan_oleh_role',
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'file_surat',
        'instruksi',
        'lokasi_file',
    ];

    public function surat()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id');
    }

    public function disposisi()
    {
        return $this->belongsTo(Disposisi::class, 'disposisi_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'arsipkan_oleh');
    }
}
