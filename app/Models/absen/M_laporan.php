<?php
namespace App\Models;

use CodeIgniter\Model;

class M_laporan extends Model
{

  public function filtersiswa($kelas, $awal, $akhir)
  {
      return $this->db->table('absensi_siswa')
          ->select('siswa.nama_siswa, kelas.nama_kelas, absensi_siswa.tanggal, absensi_siswa.status')
          ->join('siswa', 'siswa.id_siswa = absensi_siswa.id_siswa')
          ->join('kelas', 'kelas.id_kelas = siswa.id_kelas')
          ->where('siswa.id_kelas', $kelas)
          ->where('absensi_siswa.tanggal >=', $awal)
          ->where('absensi_siswa.tanggal <=', $akhir)
          ->get()
          ->getResult();
  }
   
  public function filterguru($namaguru, $awal, $akhir)
  {
      $query = $this->db->table('absensi_guru')
          ->select('guru.nik, guru.nama_guru, absensi_guru.tanggal, absensi_guru.jam_absen, absensi_guru.status')
          ->join('guru', 'guru.id_guru = absensi_guru.id_guru')
          ->where('absensi_guru.tanggal >=', $awal)
          ->where('absensi_guru.tanggal <=', $akhir);
  
      if (!empty($namaguru)) {
          $query->where('guru.nama_guru', $namaguru); // Filter berdasarkan nama guru jika diisi
      }
  
      return $query->get()->getResult();
  }
  
  
    public function input($table, $data){
      return $this->db->table($table)
              ->insert($data);
    }

    public function nis($qrData)
    {
      return $this->db->table('siswa')
                  ->where('nis', $qrData)
                  ->get()
                  ->getRow(); 
    }
    public function tampilsiswa($siswa, $tanggal)
    {
      return $this->db->table('absensi_siswa')
      ->where('id_siswa', $siswa->id_siswa)
      ->where('tanggal', $tanggal)
      ->get()
      ->getRow();
    
    }
}