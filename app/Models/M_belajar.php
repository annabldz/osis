<?php

namespace App\Models;
use CodeIgniter\Model;

class M_belajar extends Model
{
	public function tampil($table,$by){
		return $this->db->table($table)
						->orderby($by,'asc')
						->get()
						->getResult();
	}
	public function hei($table,$by, $where){
		return $this->db->table($table)
						->orderby($by,'asc')
						->where($where)
						->get()
						->getResult();
	}
	public function join($table, $table2, $on){
		return $this->db->table($table)
						->join($table2,$on)
						->get()
						->getResult();
	}
	public function siswa($table, $table2 , $table3, $on, $on2){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->get()
						->getResult();
	}
	public function rombel(){
		return $this->db->table('jadwal')
						->join('rombel','rombel.id_rombel=jadwal.id_rombel')
						->join('mapel','mapel.id_mapel=jadwal.id_mapel')
						
						->get()
						->getResult();
	}
	public function joinn(){
		return $this->db->table('jadwal')
						->join('rombel','jadwal.id_rombel=rombel.id_rombel')
						->join('mapel','jadwal.id_mapel=mapel.id_mapel')
						->join('guru','jadwal.id_guru=guru.id_guru')
						->join('blok','jadwal.id_blok=blok.id_blok')
						->join('semester','jadwal.id_semester=semester.id_semester')
						->join('tahun_ajaran','jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran')
						
						->get()
						->getResult();
	}
	public function joinnw($where){
		return $this->db->table('jadwal')
						->join('nilai','jadwal.id_nilai=nilai.id_nilai')
						->join('siswa','jadwal.id_siswa=siswa.id_siswa')
						->join('rombel','jadwal.id_rombel=rombel.id_rombel')
						->join('mapel','jadwal.id_mapel=mapel.id_mapel')
						->join('guru','jadwal.id_guru=guru.id_guru')
						->join('blok','jadwal.id_blok=blok.id_blok')
						->join('semester','jadwal.id_semester=semester.id_semester')
						->join('tahun_ajaran','jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran')
						->where($where)
						->get()
						->getResult();
	}


	public function joinm($table, $table2, $table3, $table4, $table5, $table6, $table7, $table8, $table9, $on,$on2,$on3,$on4,$on5,$on6,$on7,$on8){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->join($table4,$on3)
						->join($table5,$on4)
						->join($table6,$on5)
						->join($table7,$on6)
						->join($table8,$on7)
						->join($table9,$on8)
					
						->get()
						->getResult();
	}
	
	
	public function filter($table, $table2, $on, $filter,$filter2,$awal,$akhir){
		return $this->db->table($table)
						->join($table2,$on)
						->where($filter, $awal)
						->where($filter2,$akhir)
						->get()
						->getResult();
	}
	public function filterraport($table, $table2, $table3, $table4, $table5, $table6, $table7, $table8, $table9, $on,$on2,$on3,$on4,$on5,$on6,$on7,$on8,$filter,$filter2,$filter3, $blok, $tahun, $rombel){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->join($table4,$on3)
						->join($table5,$on4)
						->join($table6,$on5)
						->join($table7,$on6)
						->join($table8,$on7)
						->join($table9,$on8)
						->where($filter, $blok)
						->where($filter2,$tahun)
						->where($filter3,$rombel)
						->get()
						->getResult();
	}
	public function filterkelas($table, $table2, $on1, $orderBy,$filter) {
    return $this->db->table($table)
    				->orderby($orderBy, 'desc')
                    ->join($table2, $on1)
                    ->where($filter)
                    ->get()
                    ->getResult();
}

	public function jwhere($table, $table2, $on,$where){
		return $this->db->table($table)
						->join($table2,$on)
						->where($where)
						->get()
						->getResult();
	}
	public function jwhere1($table, $table2, $on,$where){
		return $this->db->table($table)
						->join($table2,$on)
						->where($where)
						->get()
						->getRow();
	}
	public function raport($table, $table2, $table3, $table4, $table5, $table6, $table7, $table8, $table9, $on,$on2,$on3,$on4,$on5,$on6,$on7,$on8,$where){
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->join($table4,$on3)
						->join($table5,$on4)
						->join($table6,$on5)
						->join($table7,$on6)
						->join($table8,$on7)
						->join($table9,$on8)
						->where($where)
						->get()
						->getRow();
	}
	public function create($data){
		$query = $this->db->table($this->table)
						  ->insert($data);
						  return $query;
	}
	
	public function input($table, $data){
		return $this->db->table($table)
						->insert($data);
	}

	public function hapus($table, $where){
		return $this->db->table($table)
						->delete($where);
	}
	public function getWhere($table, $where){
		return $this->db->table($table)
						->getWhere($where)
						->getRow();
	}
	public function edit($table,$data,$where){
		return $this->db->table($table)
						->update($data,$where);
	}
	public function joinw($table, $table2, $on, $w){  
		return $this->db->table($table)
						->join($table2,$on)
						->where($w)
						->get()
						->getRow();
	}
	public function nilairaport($table, $table2, $table3, $table4, $table5, $on,$on2,$on3,$on4,$where){  
		return $this->db->table($table)
						->join($table2,$on)
						->join($table3,$on2)
						->join($table4,$on3)
						->join($table5,$on4)
						->where($where)
						->get()
						->getRow();
	}


	public function kelas ($rombel){
		if ($rombel==""){
			$kondisirombel = "";
		}else {
			$kondisirombel = " AND rombel = '$rombel'";
		}

		if ($_POST['search']['value']){
			$search = $_POST['search']['value'];
			$kondisisearch = "nama_siswa LIKE '%search%' OR nis LIKE '%search%' OR username LIKE '%search%' OR nama_rombel LIKE '%search%' $kondisirombel";
		} else {
			$kondisisearch = "id_siswa != '' $kondisirombel";
		}
	}
	// public function jumlahsemua(){
	// 	$sQuery = "SELECT COUNT (id_siswa) FROM siswa";
	// 	$db = db_connect();
	// 	$query = $db->query($sQuery)->getRow();
	// 	return $query;
	// }
	public function jumlahfilter ($rombel){

		if ($rombel==""){
			$kondisirombel = "";
		}else {
			$kondisirombel = " AND rombel = '$rombel'";
		}

		if ($_POST['search']['value']){
			$search = $_POST['search']['value'];
			$kondisisearch = " AND (nama_siswa LIKE '%search%' OR nis LIKE '%search%' OR id_user LIKE '%search%' OR id_rombel LIKE '%search%') $kondisirombel";
		} else {
			$kondisisearch = "$kondisirombel";
		}
	}
	 // public function get_all_kelas() {
  //       return $this->db->get('rombel')->getResult();
  //   }

  //   // Ambil siswa berdasarkan kelas
  //   public function get_siswa_by_kelas($kelas_id) {
  //       $this->db->where('id_rombel', $kelas_id);
  //       return $this->db->get('siswa')->getResult();
  //   }
	public function get_all_kelas()
    {
        // Fungsi untuk mengambil semua kelas
        return $this->db->table('siswa')->get()->getResult();
    }

    public function get_siswa_by_kelas($kelas_id)
    {
        // Fungsi untuk mengambil siswa berdasarkan kelas
        return $this->db->table('siswa')->where('id_rombel', $kelas_id)->get()->getResult();
    }
}

