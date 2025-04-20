<?php

namespace App\Models;

use CodeIgniter\Model;

class LPJModel extends Model
{
    protected $table            = 'lpj2';
    protected $primaryKey       = 'id_lpj2';
    protected $useAutoIncrement = true;

    protected $allowedFields    = [
        'id_kegiatan',
        'tipe',
        'jumlah',
        'sumber',
        'penggunaan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
}
