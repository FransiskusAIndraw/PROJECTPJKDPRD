<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $fillable = [
        'user_id',
        'pesan',
        'status_notif', // 'belum_terbaca' / 'terbaca'
    ];

    // timestamps default created_at, updated_at
}
