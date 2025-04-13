<?php

namespace App\Models;

use CodeIgniter\Model;

class M_siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $allowedFields = ['id_user', 'nama_siswa', 'nis', 'code', 'deleted_at'];
    protected $useSoftDeletes = true; // Aktifkan fitur soft delete

    // Ambil data kartu siswa berdasarkan id_user
    public function kartu($id_user)
    {
        return $this->db->table('siswa')
            ->select('siswa.id_user, siswa.nama_siswa, siswa.nis, siswa.jenis_kelamin, siswa.alamat, user.foto, siswa.code')
            ->join('user', 'siswa.id_user = user.id_user')
            ->where('siswa.id_user', $id_user)
            ->get()
            ->getRow();
    }

    // Soft delete siswa + hapus user terkait
    public function softDeleteSiswa($id)
    {
        $siswa = $this->find($id);
        if ($siswa) {
            $this->update($id, ['deleted_at' => date('Y-m-d H:i:s')]);

            // Hapus juga di tabel user
            $userModel = new \App\Models\UserModel();
            $userModel->softDeleteUser($siswa['id_user']);
        }
    }

    // Restore siswa + user terkait
    public function restoreSiswa($id)
    {
        $siswa = $this->onlyDeleted()->find($id);
        if ($siswa) {
            $this->update($id, ['deleted_at' => null]);

            // Restore juga user terkait
            $userModel = new \App\Models\UserModel();
            $userModel->restoreUser($siswa['id_user']);
        }
    }
}
