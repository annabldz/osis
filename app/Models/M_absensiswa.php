<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_absensiswa extends Model
{
    protected $table = 'absensi_siswa';
    protected $primaryKey = 'id_absensiswa';
    protected $allowedFields = ['id_siswa', 'nis', 'tanggal', 'jam_absen', 'status', 'jam_masuk', 'jam_pulang', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by', 'created_at', 'created_by'];

    public function insertData($data)
    {
        return $this->insert($data);
    }
}

?>
