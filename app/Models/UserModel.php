<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user'; // Ganti sesuai nama tabel kamu
    protected $primaryKey = 'id_user';

    protected $allowedFields = [
        'nama_user',         // atau 'nama_user' sesuai struktur database kamu
        'email',
        'username',
        'password',
        'reset_token',
        'reset_expires_at',
        // tambahkan kolom lain kalau perlu
    ];

    protected $useTimestamps = false; // atau true kalau kamu pakai created_at/updated_at
}
