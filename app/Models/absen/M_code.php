<?php 
namespace App\Models;
use CodeIgniter\Model;

class M_code extends Model
{
    protected $table = 'siswa'; // Nama tabel di database
    protected $primaryKey = 'id_siswa'; // Primary key (kalau beda, sesuaikan)
    protected $allowedFields = ['nis', 'code']; // Kolom yang bisa di-update

    public function getUserByNIS($nis)
{
    return $this->db->table('siswa')
        ->select('siswa.*, user.*, kelas.*') // Pilih semua kolom yang diperlukan
        ->join('user', 'siswa.id_user = user.id_user', 'left')
        ->join('kelas', 'siswa.id_kelas = kelas.id_kelas', 'left')
        ->where('siswa.nis', $nis)
        ->get()
        ->getRow(); // Pastikan hanya satu hasil yang diambil
}
    public function updateQRCode($nis, $fileName)
{
    return $this->db->table('siswa')
        ->where('nis', $nis)
        ->update(['code' => $fileName]);
}

    public function join2($table, $table2, $table3, $on, $on2){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->get()
						->getResult();
	}
    public function joinsiswa (){
		return $this->db->table('siswa')
						->join('user', 'siswa.id_user=user.id_user')
						->join('kelas', 'siswa.id_kelas=kelas.id_kelas')
                        ->where('siswa.nis', $nis) // Tambahkan filter berdasarkan NIS
                        ->get()
						->getRow();

	}
    
}
?>