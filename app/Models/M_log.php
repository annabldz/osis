<?php

namespace App\Models;
use CodeIgniter\Model;

class M_log extends Model {
    protected $table = 'log';
    protected $primaryKey = 'id_log';
    protected $allowedFields = ['id_user', 'activity', 'ip_address', 'created_at'];

    public function saveLog($id_user, $activity, $ip_address) {
        return $this->insert([
            'id_user'   => $id_user,
            'activity'  => $activity,
            'ip_address'=> $ip_address,
            'created_at'=> date('Y-m-d H:i:s') // Pastikan format timestamp benar
        ]);
    }
    

    public function getLogs() {
    $this->db->select('log.*, user.username, user.nama AS nama_user');
    $this->db->from('log');
    $this->db->join('user', 'user.id_user = log.id_user');
    $this->db->order_by('created_at', 'DESC');
    return $this->findAll();
}

public function getAllLogs()
{
    $query = $this->db->table('log')
        ->select('log.*, user.nama as nama_user, user.username')
        ->join('user', 'user.id_user = log.id_user', 'LEFT') // Pastikan LEFT JOIN
        ->orderBy('created_at', 'DESC')
        ->get();

    if (!$query) {
        return []; // Jika query gagal, kembalikan array kosong agar tidak error
    }

    return $query->getResultArray(); // Ubah ke getResultArray() jika ingin array, atau getResult() untuk objek
}

public function getLogsByUser($id_user)
    {
        return $this->where('id_user', $id_user)->findAll();
    }
}