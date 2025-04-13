<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_deleteabsensiswa extends Model
{
    protected $table = 'absensi_siswa';
    protected $primaryKey = 'id_absensiswa'; // Ganti kalau primary key kamu beda
    protected $allowedFields = ['deleted_at', 'deleted_by', 'kondisi'];

    public function softDelete($id_absensiswa)
    {
        $now = date('Y-m-d H:i:s');
        $deleted_by = session()->get('id');

        return $this->db->table('absensi_siswa')
            ->where('id_absensiswa', $id_absensiswa)
            ->update([
                'deleted_at' => $now,
                'deleted_by' => $deleted_by,
                'kondisi' => 1
            ]);
    }

    public function restore($id_absensiswa)
    {
        return $this->db->table('absensi_siswa')
            ->where('id_absensiswa', $id_absensiswa)
            ->update([
                'deleted_at' => null,
                'deleted_by' => null,
                'kondisi' => 0
            ]);
    }

    public function getDeletedAbsensi()
    {
        return $this->db->table('absensi_siswa')
                        ->join('siswa', 'absensi_siswa.id_siswa = siswa.id_siswa')
                        ->join('user', 'siswa.id_user = user.id_user')
                        ->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
                        ->select('absensi_siswa.id_absensiswa, siswa.id_user, siswa.nama_siswa, siswa.nis, kelas.nama_kelas, absensi_siswa.tanggal, absensi_siswa.jam_absen, absensi_siswa.jam_masuk, absensi_siswa.jam_pulang, absensi_siswa.status')
                        ->where('absensi_siswa.kondisi', 1)
                        ->get()
                        ->getResult();
    }
}
