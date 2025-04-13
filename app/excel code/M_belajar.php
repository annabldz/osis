<?php

namespace App\Models;
use CodeIgniter\Model;

class M_belajar extends Model
{
	public function tampil($table){
		return $this->db->table($table)
						->get()
						->getResult();
	}
	public function join($table, $table2, $on){
		return $this->db->table($table)
						->join($table2,$on)
						->get()
						->getResult();
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
}