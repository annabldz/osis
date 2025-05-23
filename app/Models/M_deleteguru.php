<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_deleteguru extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $allowedFields = ['id_user']; 

    public function softDelete($id_anggota)
    {
        $anggota = $this->select('id_user')->where('id_anggota', $id_anggota)->first();
    
        if ($anggota) {
            $now = date('Y-m-d H:i:s');
            $deleted_by = session()->get('id');
    
            // Update tabel user
            $this->db->table('user')
                ->where('id_user', $anggota['id_user'])
                ->update([
                    'kondisi'     => 1,
                    'deleted_at'  => $now,
                    'deleted_by'  => $deleted_by
                ]);
    
            // Update tabel guru juga!
            return $this->db->table('anggota')
                ->where('id_anggota', $id_anggota)
                ->update([
                    'kondisi'     => 1,
                    'deleted_at' => $now,
                    'deleted_by' => $deleted_by
                ]);
        }
    
        return false;
    }
    

    public function restore($id_anggota)
    {
        $anggota = $this->select('id_user')->where('id_anggota', $id_anggota)->first();
    
        if ($anggota) {
            // Reset tabel user
            $this->db->table('user')
                ->where('id_user', $anggota['id_user'])
                ->update([
                    'kondisi'     => 0,
                    'deleted_at'  => null,
                    'deleted_by'  => null
                ]);
    
            // Reset tabel guru juga
            return $this->db->table('anggota')
                ->where('id_anggota', $id_anggota)
                ->update([
                    'kondisi'     => 0,
                    'deleted_at' => null,
                    'deleted_by' => null
                ]);
        }
    
        return false;
    }
    

    public function getDeletedGuru()
    {   
        return $this->db->table('anggota')
            ->join('user', 'anggota.id_user = user.id_user')
            ->select('anggota.*, user.kondisi, user.foto, user.email, user.username, user.deleted_at, user.deleted_by') 
            ->where('user.kondisi', 1)
            ->get()
            ->getResult();  
    }
}
?>
