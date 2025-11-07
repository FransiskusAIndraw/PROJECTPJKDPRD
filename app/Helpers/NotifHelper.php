<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Notifikasi;

class NotifHelper
{
    /**
     * Kirim notifikasi ke user berdasarkan role atau user_id
     *
     * @param string|int $roleAtauUserId - bisa nama role atau ID langsung
     * @param string $pesan
     * @param string|null $url
     */
    public static function send($roleAtauUserId, $pesan, $url = null)
    {
        // Jika param berupa role (string & bukan angka)
        if (!is_numeric($roleAtauUserId)) {
            $users = User::where('roles', $roleAtauUserId)->get(); // semua user dengan role itu
            foreach ($users as $user) {
                Notifikasi::create([
                    'user_id' => $user->id,
                    'pesan' => $pesan,
                    'status_notif' => 'belum_terbaca',
                    'url' => $url,
                ]);
            }
            return;
        }

        // Jika berupa user_id langsung
        Notifikasi::create([
            'user_id' => $roleAtauUserId,
            'pesan' => $pesan,
            'status_notif' => 'belum_terbaca',
            'url' => $url,
        ]);
    }
}
