<?php

namespace App\Models;

use CodeIgniter\Model;

class M_libur extends Model
{
    protected $table = 'libur';
    protected $primaryKey = 'id_libur';
    protected $allowedFields = ['tanggal', 'keterangan', 'created_at'];
}
