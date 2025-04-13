<?php

namespace App\Models;
use CodeIgniter\Model;

class M_web extends Model
{
    protected $table = 'setting'; // atau tabel lain yang kamu pakai
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['nama', 'foto']; // <--- tambahkan ini
}
