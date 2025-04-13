<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table = 'keuangan';
    protected $primaryKey = 'id_keuangan';
    protected $allowedFields = ['tanggal', 'keterangan', 'tipe', 'jumlah', 'nota'];
}
