<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';

    protected $allowedFields = [
        'judul_kegiatan',
        'deskripsi_kegiatan',
        'tanggal_kegiatan',
        'waktu',
        'lokasi',
        'status_kegiatan',
        'proposal_file',
        'id_proker',
        'disetujui_oleh',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
        'deleted_by',
    ];

    public function join ()
    {
        return $this->select('
                proker.judul_proker AS bagian_proker,
                kegiatan.judul_kegiatan,
                kegiatan.tanggal_kegiatan,
                kegiatan.waktu,
                kegiatan.lokasi,
                kegiatan.proposal_file,
                dokumentasi.link_drive,
                kegiatan.status_kegiatan
            ')
            ->join('proker', 'proker.id_proker = kegiatan.id_proker')
            ->join('dokumentasi', 'dokumentasi.id_kegiatan = kegiatan.id_kegiatan', 'left')
            ->limit(100) // batasin hasil

            ->findAll();
    }

    public function proposal(){
        return $this->db->table('kegiatan')
                        ->join('proker', 'kegiatan.id_proker=proker.id_proker')
                        ->where('kegiatan.proposal_file !=', '')
                        ->where('kegiatan.proposal_file !=', null)

                        ->get()
                        ->getResult();
    }
    
}
