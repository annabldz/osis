<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_deletesiswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['id_user']; 

    public function softDelete($id_siswa)
    {
        $siswa = $this->select('id_user')->where('id_siswa', $id_siswa)->first();
        if ($siswa) {
            $now = date('Y-m-d H:i:s');
            $deleted_by = session()->get('id');

            // Update user
            $this->db->table('user')
                ->where('id_user', $siswa['id_user'])
                ->update([
                    'kondisi'     => 1,
                    'deleted_at'  => $now,
                    'deleted_by'  => $deleted_by
                ]);

            // Update siswa juga
            return $this->db->table('siswa')
                ->where('id_siswa', $id_siswa)
                ->update([
                    'kondisi'     => 1,
                    'deleted_at' => $now,
                    'deleted_by' => $deleted_by
                ]);
        }
        return false;
    }

    public function restore($id_siswa)
    {
        $siswa = $this->select('id_user')->where('id_siswa', $id_siswa)->first();
        if ($siswa) {
            // Reset user
            $this->db->table('user')
                ->where('id_user', $siswa['id_user'])
                ->update([
                    'kondisi'     => 0,
                    'deleted_at'  => null,
                    'deleted_by'  => null
                ]);

            // Reset siswa juga
            return $this->db->table('siswa')
                ->where('id_siswa', $id_siswa)
                ->update([
                    'kondisi'     => 0,
                    'deleted_at' => null,
                    'deleted_by' => null
                ]);
        }
        return false;
    }

    public function getDeletedSiswa()
    {   
        return $this->db->table('siswa')
            ->join('user', 'siswa.id_user = user.id_user')
            ->select('siswa.*, user.kondisi, user.foto, user.username') 
            ->where('user.kondisi', 1)
            ->get()
            ->getResult();  
    }
}
