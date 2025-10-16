<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'pengirim',
        'perihal',
        'file_surat',
        'status',
        'created_by',
        'reviewed_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function disposisis()
    {
        return $this->hasMany(Disposisi::class, 'surat_id');
    }
}
