<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumentasiModel extends Model
{
    protected $table      = 'dokumentasi';
    protected $primaryKey = 'id_dokumentasi';

    protected $allowedFields = [
        'judul_dokumentasi',
        'link_drive',
        'kategori',
        'bulan',
        'tahun'
    ];
}
