<?php

namespace App\Models;

use CodeIgniter\Model;

class M_absensi extends Model
{
    protected $table = 'absensi';

    public function getBelumAbsen($tanggal)
    {
        return $this->db->table('user')
            ->select('user.id_user, user.nama, user.email, user.no_wa, user.telegram_id')
            ->whereNotIn('user.id_user', function ($builder) use ($tanggal) {
                return $builder->select('id_user')->from('absensi')->where('tanggal', $tanggal);
            })
            ->get()
            ->getResult();
    }
}
