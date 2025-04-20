<?php

namespace App\Models;

use CodeIgniter\Model;

class M_LPJ extends Model
{
    protected $table = 'lpj';
    protected $primaryKey = 'id_lpj';
    protected $useAutoIncrement = true;

    protected $returnType = 'array'; // Bisa juga 'object' kalau kamu mau
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_kegiatan',
        'tipe',
        'jumlah',
        'sumber',
        'penggunaan',
        'bukti',
        'tanggal',
        'created_at'
    ];

    protected $useTimestamps = false;

    /**
     * Ambil semua LPJ dengan data kegiatan yang terkait
     */
    public function getAllWithKegiatan()
    {
        return $this->db->table($this->table)
                        ->select('lpj.*, kegiatan.judul_kegiatan, kegiatan.tanggal_kegiatan, kegiatan.status_kegiatan') // pilih kolom tambahan dari kegiatan
                        ->join('kegiatan', 'lpj.id_kegiatan = kegiatan.id_kegiatan', 'left')
                        ->orderBy('lpj.created_at', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    public function getByIdKegiatan($id_kegiatan)
    {
        $result = $this->db->table($this->table)
                        ->select('lpj.*, kegiatan.judul_kegiatan, kegiatan.tanggal_kegiatan, kegiatan.status_kegiatan') 
                        ->join('kegiatan', 'lpj.id_kegiatan = kegiatan.id_kegiatan', 'left')
                        ->where('lpj.id_kegiatan', $id_kegiatan)
                        ->orderBy('lpj.created_at', 'ASC')
                        ->get()
                        ->getResultArray();
    
        if (empty($result)) {
            return null;
        }
    
        // Ambil data kegiatan dari entri pertama
        $kegiatan = [
            'id_kegiatan'     => $result[0]['id_kegiatan'],
            'judul_kegiatan'  => $result[0]['judul_kegiatan'],
            'tanggal_kegiatan'=> $result[0]['tanggal_kegiatan'],
            'status_kegiatan' => $result[0]['status_kegiatan'],
            'lpj'             => []
        ];
    
        // Tambahkan data LPJ-nya
        foreach ($result as $row) {
            $kegiatan['lpj'][] = [
                'id_lpj'     => $row['id_lpj'],
                'tipe'       => $row['tipe'],
                'jumlah'     => $row['jumlah'],
                'sumber'     => $row['sumber'],
                'penggunaan' => $row['penggunaan'],
                'bukti'     => $row['bukti'],
                'tanggal' => $row['tanggal']
            ];
        }
    
        return $kegiatan;
    }
    

    public function getKegiatanWithLPJ()
{
    return $this->db->table('kegiatan')
                    ->select('kegiatan.*, lpj.id_lpj, lpj.tipe, lpj.jumlah, lpj.sumber, lpj.penggunaan, lpj.created_at as lpj_created_at')
                    ->join('lpj', 'lpj.id_kegiatan = kegiatan.id_kegiatan', 'left') // LEFT JOIN biar semua kegiatan muncul
                    ->orderBy('kegiatan.created_at', 'DESC')
                    ->get()
                    ->getResultArray();
}
public function getKegiatanGroupedWithLPJ()
{
    $result = $this->db->table('kegiatan')
        ->select('
            kegiatan.*, 
            proker.judul_proker, 
            lpj.id_lpj, 
            lpj.tipe, 
            lpj.jumlah, 
            lpj.sumber, 
            lpj.penggunaan, 
            lpj.created_at as lpj_created_at
        ')
        ->join('proker', 'kegiatan.id_proker = proker.id_proker')
        ->join('lpj', 'lpj.id_kegiatan = kegiatan.id_kegiatan')
        ->orderBy('kegiatan.id_kegiatan', 'DESC')
        ->get()
        ->getResultArray();

    $grouped = [];

    foreach ($result as $row) {
        $id_kegiatan = $row['id_kegiatan'];

        // Inisialisasi kegiatan jika belum ada
        if (!isset($grouped[$id_kegiatan])) {
            $grouped[$id_kegiatan] = [
                'id_kegiatan'      => $row['id_kegiatan'],
                'judul_kegiatan'   => $row['judul_kegiatan'],
                'tanggal_kegiatan' => $row['tanggal_kegiatan'],
                'waktu'            => $row['waktu'],
                'lokasi'           => $row['lokasi'],
                'status_kegiatan'  => $row['status_kegiatan'],
                'judul_proker'      => $row['judul_proker'],
                'lpj'              => []
            ];
        }

        // Masukin data LPJ kalau ada
        if (!empty($row['id_lpj'])) {
            $grouped[$id_kegiatan]['lpj'][] = [
                'id_lpj'     => $row['id_lpj'],
                'tipe'       => $row['tipe'],
                'jumlah'     => $row['jumlah'],
                'sumber'     => $row['sumber'],
                'penggunaan' => $row['penggunaan'],
                'created_at' => $row['lpj_created_at'],
            ];
        }
    }

    return array_values($grouped); // biar jadi indexed array
}

}
