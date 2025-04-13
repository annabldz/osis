<?php

namespace App\Models;

use CodeIgniter\Model;

class M_gurukartu extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    protected $allowedFields = ['id_user', 'nama_guru', 'nik', 'code'];

    public function kartu($id_user)
    {
        return $this->db->table('guru')
            ->select('guru.id_user, guru.nama_guru, guru.nik, guru.jenis_kelamin, guru.alamat, user.foto, guru.code')
            ->join('user', 'guru.id_user = user.id_user')
            ->where('guru.id_user', $id_user)
            ->get()
            ->getRow();
    }
}
