<?php 

namespace App\Models;

use CodeIgniter\Model;

class M_guru extends Model
{
    protected $table = 'guru'; 
    protected $primaryKey = 'id_guru'; 
    protected $allowedFields = ['id_user', 'nik', 'code', 'deleted_at'];
    protected $useSoftDeletes = true; // Aktifkan soft delete

    // Ambil data guru + user berdasarkan NIK
    public function getUserByNIK($nik)
    {
        return $this->db->table('guru')
            ->select('guru.*, user.*')
            ->join('user', 'guru.id_user = user.id_user', 'left')
            ->where('guru.nik', $nik)
            ->get()
            ->getRow();
    }

    // Update QR Code guru berdasarkan NIK
    public function updateQRguru($nik, $fileName)
    {
        return $this->db->table('guru')
            ->where('nik', $nik)
            ->update(['code' => $fileName]);
    }

    // Soft delete guru dan otomatis soft delete user yang terkait
    public function softDeleteGuru($id)
    {
        $guru = $this->find($id);
        if ($guru) {
            $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);

            // Hapus juga di tabel user
            $userModel = new \App\Models\UserModel();
            $userModel->softDeleteUser($guru['id_user']);
        }
    }

    // Restore guru dan otomatis restore user yang terkait
    public function restoreGuru($id)
    {
        $guru = $this->onlyDeleted()->find($id);
        if ($guru) {
            $this->update($id, ['deleted_at' => null]);

            // Restore juga user terkait
            $userModel = new \App\Models\UserModel();
            $userModel->restoreUser($guru['id_user']);
        }
    }
}
