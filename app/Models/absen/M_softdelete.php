<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_softdelete extends Model
{
    
    protected $table = 'user'; 
    protected $table2 = 'guru'; 
    protected $table3 = 'siswa'; 
    protected $table4 = 'kelas'; 
    protected $table5 = 'absensi_guru'; 
    protected $table6 = 'absensi_siswa'; 

    protected $primaryKey = 'id_user'; 
    protected $primaryKey2 = 'id_guru'; 
    protected $primaryKey3 = 'id_siswa'; 
    protected $primaryKey4 = 'id_kelas'; 
    protected $primaryKey5 = 'id_absenguru'; 
    protected $primaryKey6 = 'id_absensiswa'; 

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at'; // Jika pakai soft delete
    protected $useSoftDeletes = true; // Aktifkan soft delete
    protected $allowedFields = ['kondisi']; // Tambahkan kolom yang boleh di-update

    public function deleteuser($id)
    {
        $userID = session()->get('id'); // Ambil ID user dari session
    
        log_message('debug', "Soft delete dijalankan untuk User ID: $id oleh Admin ID: $userID");
    
        // Pastikan user ada di tabel user
        $user = $this->db->table('user')
            ->where('id_user', $id) // Pastikan ini sesuai dengan kolom di database
            ->get()
            ->getRow(); 
    
        if (!$user) {
            log_message('error', "Soft delete gagal: User ID $id tidak ditemukan.");
            return false;
        }
    
        // Update soft delete di tabel user
        $resultUser = $this->db->table('user')
            ->where('id_user', $id)
            ->update([
                'kondisi'    => 1,
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $userID
            ]);
    
        log_message('debug', "Update user status: " . json_encode($resultUser));
    
        // Update soft delete di tabel guru
        $resultGuru = $this->db->table('guru')
            ->where('id_user', $id) // Pastikan kolom ini benar
            ->update([
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => $userID
            ]);
    
        log_message('debug', "Update guru status: " . json_encode($resultGuru));
    
        if (!$resultUser || !$resultGuru) {
            log_message('error', "Soft delete gagal pada user atau guru.");
            return false;
        }
    
        return true;
    }
    

    public function restoreuser($id)
    {
        log_message('debug', "Mulai restore user dengan ID: $id");
    
        // Cek apakah user yang di-restore ada
        $user = $this->db->table('user')
            ->where('id_user', $id)
            ->where('kondisi', 1)
            ->get()
            ->getRow(); 
    
        if (!$user) {
            log_message('error', "Restore gagal: User ID $id tidak ditemukan atau belum dihapus.");
            return false;
        }
    
        // Restore data user
        $resultUser = $this->db->table('user')
            ->where('id_user', $id)
            ->update([
                'kondisi'    => 0,
                'deleted_at' => NULL,
                'deleted_by' => NULL
            ]);
    
        log_message('debug', "Restore user status: " . json_encode($resultUser));
    
        // Restore data guru
        $resultGuru = $this->db->table('guru')
            ->where('id_user', $id)
            ->update([
                'deleted_at' => NULL,
                'deleted_by' => NULL
            ]);
    
        log_message('debug', "Restore guru status: " . json_encode($resultGuru));
    
        // Jika salah satu gagal, return false
        if (!$resultUser || !$resultGuru) {
            log_message('error', "Restore gagal pada user atau guru.");
            return false;
        }
    
        return true; // Berhasil restore
    }
    

    
    


    public function getDeletedUser()
    {   
        return $this->db->table('user')
        ->select('user.*, user.kondisi') 
        ->where('user.kondisi', 1)
        ->get()
        ->getResult();  
    }
}

?>
