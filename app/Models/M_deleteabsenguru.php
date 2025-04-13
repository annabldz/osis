<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_deleteabsenguru extends Model
{
    protected $table = 'absensi_guru';
    protected $primaryKey = 'id_absenguru'; // Ganti kalau primary key kamu beda
    protected $allowedFields = ['deleted_at', 'deleted_by', 'kondisi'];

    public function softDelete($id_absenguru)
    {
        $now = date('Y-m-d H:i:s');
        $deleted_by = session()->get('id');

        return $this->db->table('absensi_guru')
            ->where('id_absenguru', $id_absenguru)
            ->update([
                'deleted_at' => $now,
                'deleted_by' => $deleted_by,
                'kondisi' => 1
            ]);
    }

    public function restore($id_absenguru)
    {
        return $this->db->table('absensi_guru')
            ->where('id_absenguru', $id_absenguru)
            ->update([
                'deleted_at' => null,
                'deleted_by' => null,
                'kondisi' => 0
            ]);
    }

    public function getDeletedAbsensi()
    {
        return $this->db->table('absensi_guru')
                        ->join('guru', 'absensi_guru.id_guru = guru.id_guru')
                        ->join('user', 'guru.id_user = user.id_user')
                        ->select('absensi_guru.id_absenguru, guru.id_user, guru.nama_guru, guru.nik, absensi_guru.tanggal, absensi_guru.jam_absen, absensi_guru.jam_masuk, absensi_guru.jam_pulang, absensi_guru.status')
                        ->where('absensi_guru.kondisi', 1)
                        ->get()
                        ->getResult();
    }
}
