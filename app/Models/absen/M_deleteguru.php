<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_deleteguru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    protected $allowedFields = ['id_user']; 

    public function softDelete($id_guru)
    {
        $guru = $this->select('id_user')->where('id_guru', $id_guru)->first();
    
        if ($guru) {
            $now = date('Y-m-d H:i:s');
            $deleted_by = session()->get('id');
    
            // Update tabel user
            $this->db->table('user')
                ->where('id_user', $guru['id_user'])
                ->update([
                    'kondisi'     => 1,
                    'deleted_at'  => $now,
                    'deleted_by'  => $deleted_by
                ]);
    
            // Update tabel guru juga!
            return $this->db->table('guru')
                ->where('id_guru', $id_guru)
                ->update([
                    'kondisi'     => 1,
                    'deleted_at' => $now,
                    'deleted_by' => $deleted_by
                ]);
        }
    
        return false;
    }
    

    public function restore($id_guru)
    {
        $guru = $this->select('id_user')->where('id_guru', $id_guru)->first();
    
        if ($guru) {
            // Reset tabel user
            $this->db->table('user')
                ->where('id_user', $guru['id_user'])
                ->update([
                    'kondisi'     => 0,
                    'deleted_at'  => null,
                    'deleted_by'  => null
                ]);
    
            // Reset tabel guru juga
            return $this->db->table('guru')
                ->where('id_guru', $id_guru)
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
        return $this->db->table('guru')
            ->join('user', 'guru.id_user = user.id_user')
            ->select('guru.*, user.kondisi, user.foto, user.username, user.deleted_at, user.deleted_by') 
            ->where('user.kondisi', 1)
            ->get()
            ->getResult();  
    }
}
?>
