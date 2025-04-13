<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProkerModel extends Model
{
    protected $table = 'proker';
    protected $primaryKey = 'id_proker';
    protected $allowedFields = ['judul_proker', 'status', 'created_at', 'updated_at'];
}

?>