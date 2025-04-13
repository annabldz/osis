<?php

namespace App\Controllers;
use App\Models\M_belajar;
use TCPDF;
use Dompdf\Dompdf;

class gudang extends BaseController
{

	public function aksi_login()
	{
		$model = new M_belajar;
		$data = array(
			'username'=> $this->request->getPost('email'),
			'password'=> MD5($this->request->getPost('pswd')),
		);
	    $cek = $model->getWhere('user',$data);	 
	       
	    if ($cek != null) {
	    	session()->set('id',$cek->id_user);
	    	session()->set('user',$cek->username);
	    	session()->set('level',$cek->level);
	    	return redirect()->to('home/halamanutama');
	    }else{
	    	return redirect()->to('/home/login');
	    }
	}
	public function reset_pass ($id)
	{

		$Sim= new M_belajar;
		$chiuw= array('id_user' =>$id);
		$data = array(
			
			"password"=>MD5('1111'),	
		);
        $chichi['chelsica']=$Sim->edit('user',$data,$chiuw);
		return redirect()->to('gudang/profile');
	}
	public function change_pass()
	{
		$model= new M_belajar();
		$chiuw= array('id_user' => session()->get('id'));
		$data = array(
			'password'=> MD5($this->request->getPost('newpassword')),
		);
		$model->edit('user',$data,$chiuw);
		return redirect()->to('/gudang/profile')->with('success','Password berhasil diganti');
	}
	
	public function logout()
	{
		session()->destroy();
		return redirect()->to('/home/login');
	}
	public function aksi_register()
{
    $model = new M_belajar();

    $data = array(
        'username' => $this->request->getPost('username'),
        'password' => MD5($this->request->getPost('password')),
        'level' => $this->request->getPost('level')
    );

    $model->input('user', $data);
 
    $where = array("username" => $this->request->getPost('username'));
    $chichi = $model->getWhere('user', $where);

        $data2 = array(
            'id_user' => $chichi->id_user,
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'no_telp' => $this->request->getPost('no_telp'),
            'no_ktp' => $this->request->getPost('no_ktp'),
        );

       
        $model->input('pelanggan', $data2);
    return redirect()->to('/home/login');
}

	public function profile()
{

    if (session()->get('level') > 0) {
        $Sim = new M_belajar; 

        if (session()->get('level') == "2") {
            $where = array('karyawan.id_user' => session()->get('id'));
            $chichi['chelsica'] = $Sim->joinw('user', 'karyawan', 'user.id_user=karyawan.id_user', $where);
        } else if (session()->get('level') == "1") {
            $where = array('id_user' => session()->get('id'));
            $chichi['chelsica'] = $Sim->getWhere('user', $where);
        } else if (session()->get('level') == "3") {
            $where = array('pelanggan.id_user' => session()->get('id'));
            $chichi['chelsica'] = $Sim->joinw('user', 'pelanggan', 'user.id_user=pelanggan.id_user', $where);
        } else {
            return redirect()->to('/error');
        }
        $chelsica = $chichi['chelsica'];
        if (session()->get('level') == "3") {
            $chichi['name'] = $chelsica->nama_pelanggan ?? $chelsica->username;
        } else if (session()->get('level') == "2") { 
            $chichi['name'] = $chelsica->nama_karyawan ?? $chelsica->username;
        } else { 
            $chichi['name'] = $chelsica->username;
        }
        echo view('header', $this->data);
        echo view('menu');
        echo view('profile', $chichi); 
        echo view('footer');
    } else {
        return redirect()->to('/home/login');
    }
}
public function update_profile()
{
    $Sim = new M_belajar();
    $userId = session()->get('id');
    $userLevel = session()->get('level');

    if ($userLevel == "2") { 
        $where = ['karyawan.id_user' => $userId];
        $nameColumn = 'nama_karyawan';
        $table = 'karyawan';
    } elseif ($userLevel == "1") { 
        $where = ['id_user' => $userId];
        $nameColumn = 'username';
        $table = 'user';
    } elseif ($userLevel == "3") { 
        $where = ['pelanggan.id_user' => $userId];
        $nameColumn = 'nama_pelanggan';
        $table = 'pelanggan';
    } else {
        return redirect()->to('/error')->with('error', 'Invalid user level.');
    }

    $newName = $this->request->getPost('fullName');
    if (!$newName) {
        return redirect()->back()->with('error', 'Full Name is required.');
    }
    $data = [$nameColumn => $newName];
    $Sim->edit($table, $data, $where);

    $file = $this->request->getFile('profile_image');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $uploadPath = 'img/';
        $newFileName = $userId . '_' . $file->getRandomName();
        if ($file->move($uploadPath, $newFileName)) {
            $currentData = $Sim->getWhere('user', ['id_user' => $userId]);
             $oldFileName = $currentData->foto ?? null;
            $Sim->edit('user', ['foto' => $newFileName], ['id_user' => $userId]);
            if ($oldFileName && file_exists($uploadPath . $oldFileName)) {
                unlink($uploadPath . $oldFileName);
            }
        } else {
            return redirect()->back()->with('error', 'Failed to upload the profile image.');
        }
    }

    return redirect()->to('/gudang/profile')->with('successprofil', 'Profile updated successfully.');
}
public function delete_profile_picture()
{
    $Sim = new M_belajar();
    $userId = session()->get('id');

    $currentData = $Sim->getWhere('user', ['id_user' => $userId]);
    $oldFileName = $currentData->foto ?? null;

    if ($oldFileName) {
        $filePath = 'img/' . $oldFileName;

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $Sim->edit('user', ['foto' => null], ['id_user' => $userId]);
    }

    return redirect()->to('/gudang/profile')->with('successprofil', 'Profile picture removed successfully.');
}















	public function inputuser()
	{
		$model= new M_belajar();
		$data = array(
			'id_user' => $this->request->getPost('id_user'),
			'username'=> $this->request->getPost('username'),
			'password'=> MD5($this->request->getPost('password')),
			'level'=> $this->request->getPost('level'),
		);
		$model->input('user', $data);
		return redirect()->to('/gudang/tampiluser');
	}
	public function inputkamar()
	{
		$model= new M_belajar();
		$data = array(
			'nomor_kamar' => $this->request->getPost('nomor_kamar'),
			'id_tipe'=> $this->request->getPost('id_tipe'),
			'status'=> $this->request->getPost('status')
		);
		$model->input('kamar', $data);
		return redirect()->to('/gudang/tampilkamar');
	}
	public function inputtipekamar()
	{
        $model= new M_belajar();
        $data = array(
        	'tipe_kamar'=> $this->request->getPost('tipe_kamar'),
        	'lokasi'=> $this->request->getPost('lokasi'),
        	'harga'=> $this->request->getPost('harga'),
        	'orang'=> $this->request->getPost('orang'),
        	'foto'=> $this->request->getPost('file'),
        );

         $file = $_FILES["file"];
         $validExtensions = ["jpg", "png", "jpeg"];
         $extension = pathinfo($file["name"], PATHINFO_EXTENSION);
         $timestamp = time(); 
         $newFileName = $timestamp . "_" . $file["name"]; 
         move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
         $data['foto'] = $newFileName; 

        $model = new M_belajar();
        $model->input('tipe_kamar', $data);
        return redirect()->to('/gudang/tampiltipekamar');
    }
    

	public function inputpemesanan()
    {
    	$model= new M_belajar();
    	
	  	$id_user = session()->get('id');

    	$pelanggan = $model->getWhere('pelanggan', ['id_user' => $id_user]);

    	$id_pelanggan = $pelanggan->id_pelanggan;


    	$id_tipe = $this->request->getPost('tipe_kamar');

    	$kamar = $model->getWhere('kamar', ['id_tipe' => $id_tipe]);
    $id_kamar = $kamar->id_kamar; 

    $karyawan = $model->getAll('karyawan');

             $randomIndex = array_rand($karyawan); 
             $id_karyawan = $karyawan[$randomIndex]->id_karyawan;


             $data = array(
             	'id_kamar' => $this->request->getPost('id_kamar'),
             	'nama_tamu' => $this->request->getPost('nama_tamu'),
             	'id_pelanggan' => $id_pelanggan,  
             	'id_karyawan' => $id_karyawan,
             	'cek_in'=> $this->request->getPost('checkin'),
             	'cek_out'=> $this->request->getPost('checkout'),
             	'status_pesan'=> $this->request->getPost('status'),
             	'kuantitas'=> $this->request->getPost('kuantitas'),
             	'id_tipe' => $this->request->getPost('id_tipe'),
             );
             $model->input('pemesanan',$data);

         if (session()->get('level')==1||session()->get('level')==2){
			return redirect()->to('/gudang/tampilpemesanan');
		}else if (session()->get('level')==3){
			return redirect()->to('/gudang/terimakasih');
		}else{
			return redirect()->to('/home/login');
		}
	}
	
	public function inputkaryawan()
{
    $model = new M_belajar();
// Step 1: Insert user data
    $data = array(
        'username' => $this->request->getPost('username'),
        'password' => MD5($this->request->getPost('password')),
        'level' => $this->request->getPost('level')
    );

    $model->input('user', $data);
    
    // Step 2: Fetch the inserted user by username
    $where = array("username" => $this->request->getPost('username')); // Corrected here
    $chichi = $model->getWhere('user', $where);// Ensure getRow() or appropriate fetch method is used

    // Step 3: Insert karyawan data if user exists
        $data2 = array(
            'id_user' => $chichi->id_user,
            'nama_karyawan' => $this->request->getPost('nama_karyawan'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'gaji' => $this->request->getPost('gaji')
        );
        $model->input('karyawan', $data2);
    return redirect()->to('/gudang/tampilkaryawan');
}

















	public function user()
	{
		if (session()->get('level')==1){
			echo view ('header', $this->data);
			echo view ('menu');
			echo view ('user');
			echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function terimakasih()
	{
		if (session()->get('level')==3){
			echo view ('header', $this->data);
			echo view ('menu');
			echo view ('terimakasih');
			echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}

	public function tipekamar()
	{
		if (session()->get('level')==1){
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tipekamar');
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
		public function pemesanan()
	{
		if (session()->get('level')==1||session()->get('level')==3||session()->get('level')==2){
		$Sim = new M_belajar;
        $where = ('id_tipe');
        $chichi['chelsica'] = $Sim->tampil('tipe_kamar', $where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('pemesanan',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	
	public function karyawan()
	{
		if (session()->get('level')==1){
		$Sim = new M_belajar;
		$where = ('id_user');
		$chichi['chelsica']=$Sim->tampil('user',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('karyawan',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}

	public function pelanggan()
	{
		if (session()->get('level')==1){
		$Sim = new M_belajar;
		$where = ('id_user');
		$chichi['chelsica']=$Sim->tampil('user',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('pelanggan',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function kamar()
	{
		if (session()->get('level')==1){
		$Sim = new M_belajar;
		$where = ('id_tipe');
		$chichi['chelsica']=$Sim->tampil('tipe_kamar',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('kamar',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function pesan($id)
    {
    	if (session()->get('level')==1||session()->get('level')==3||session()->get('level')==2){
        $Sim = new M_belajar;
        $chiuw= array('kamar.id_tipe' =>$id);
        $chichi['chelsica']=$Sim->joinw('kamar','tipe_kamar','kamar.id_tipe=tipe_kamar.id_tipe',$chiuw);
        echo view('header', $this->data);
        echo view ('menu');
        echo view('pesan', $chichi);
        echo view('footer');      
        }else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}    
    }

















	public function tampiluser()
	{
		if (session()->get('level')==1||session()->get('level')==2){
		$Sim = new M_belajar;
		$where = ('id_user');
		$chichi['chelsica']=$Sim->tampil('user',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampiluser',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function tampiltipekamar()
	{
		if (session()->get('level')==1||session()->get('level')==2||session()->get('level')==3){
		$Sim = new M_belajar;
		$where = ('id_tipe');
		$chichi['chelsica']=$Sim->tampil('tipe_kamar',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampiltipekamar',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	
	public function tampilpemesanan()
	{
		if (session()->get('level')==1||session()->get('level')==2){
		$Sim = new M_belajar;
		$where = ('id_pemesanan');
		$chichi['chelsica']=$Sim->join5('pemesanan', 'kamar', 'pelanggan', 'karyawan', 'tipe_kamar', 
                   'pemesanan.id_kamar = kamar.id_kamar', 
                   'pemesanan.id_pelanggan = pelanggan.id_pelanggan',
                   'pemesanan.id_karyawan = karyawan.id_karyawan',
                   'kamar.id_tipe = tipe_kamar.id_tipe',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampilpemesanan',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function tampilpemesanan2()
{
    if (session()->get('level') == 3) {
        $Sim = new M_belajar;
        $where = ('id_pemesanan');
        $id_user = session()->get('id');
        $pelanggan = $Sim->getWhere('pelanggan', ['id_user' => $id_user]);
        $id_pelanggan = $pelanggan->id_pelanggan;

        // Correct condition for filtering
        $chichi['chelsica'] = $Sim->filterpesan(
            'pemesanan',
            'kamar',
            'pelanggan',
            'karyawan',
            'tipe_kamar',
            'pemesanan.id_kamar = kamar.id_kamar',
            'pemesanan.id_pelanggan = pelanggan.id_pelanggan',
            'pemesanan.id_karyawan = karyawan.id_karyawan',
            'kamar.id_tipe = tipe_kamar.id_tipe',$where,
            ['pemesanan.id_pelanggan' => $id_pelanggan] // Apply filter here
        );

        echo view('header', $this->data);
        echo view('menu');
        echo view('tampilpemesanan2', $chichi);
        echo view('footer');
    } else if (session()->get('level') > 0) {
        return redirect()->to('/error');
    } else {
        return redirect()->to('/home/login');
    }
}
	public function tampilkaryawan()
	{
		if (session()->get('level')==1||session()->get('level')==2){
		$Sim = new M_belajar;
		$where = ('id_karyawan');
		$chichi['chelsica']=$Sim->join('karyawan','user','karyawan.id_user=user.id_user',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampilkaryawan', $chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function tampilkamar()
	{
		if (session()->get('level')==1||session()->get('level')==2){
		$Sim = new M_belajar;
		$where = ('id_kamar');
		$chichi['chelsica']=$Sim->tampil('kamar',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampilkamar', $chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function tampilpelanggan()
	{
		if (session()->get('level')==1||session()->get('level')==2){
		$Sim = new M_belajar;
		$where = ('id_pelanggan');
		$chichi['chelsica']=$Sim->join('pelanggan','user','pelanggan.id_user=user.id_user',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('tampilpelanggan', $chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}
	public function tampilnota()
{
    if (session()->get('level') == 1 || session()->get('level') == 3 || session()->get('level') == 2) {
        $Sim = new M_belajar;
            $where = 'id_nota';
            $chichi['chelsica'] = $Sim->tampil('nota', $where);
            echo view('header', $this->data);
            echo view('menu');
            echo view('tampilnota', $chichi);
            echo view('footer');
    } else if (session()->get('level') > 0) {
        return redirect()->to('/error');
    } else {
        return redirect()->to('/home/login');
    }
}

public function fancytipekamar()
	{
		if (session()->get('level')==1||session()->get('level')==2||session()->get('level')==3){
		$Sim = new M_belajar;
		$where = ('id_tipe');
		$chichi['chelsica']=$Sim->tampil('tipe_kamar',$where);
		echo view ('header', $this->data);
		echo view ('menu');
		echo view ('fancytipekamar',$chichi);
		echo view ('footer');
		}else if (session()->get('level')>0){
			return redirect()->to('/error');
		}else{
			return redirect()->to('/home/login');
		}
	}

	
	
	


















	public function hapus_user($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_user' =>$id);
        $chichi['chelsica']=$Sim->hapus('user',$chiuw);
        return redirect()->to('gudang/tampiluser');
    }
    public function hapus_tipekamar($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_tipe' =>$id);
        $chichi['chelsica']=$Sim->hapus('tipe_kamar',$chiuw);
        return redirect()->to('gudang/tampiltipekamar');
    }
    public function hapus_barangk($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_barang_keluar' =>$id);
        $chichi['chelsica']=$Sim->hapus('barang_keluar',$chiuw);
        return redirect()->to('gudang/tampilbarangk');
    }
    
    public function hapus_karyawan($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_karyawan' =>$id);
        $chichi['chelsica']=$Sim->hapus('karyawan',$chiuw);
        return redirect()->to('gudang/tampilkaryawan');
    }
    public function hapus_karyawanuser($id)
{
    $model = new M_belajar;
    $chiuw = array('id_karyawan' => $id);
    $karyawan = $model->getWhere('karyawan', $chiuw);
        $model->hapus('karyawan', $chiuw);
        $sim = array('id_user' => $karyawan->id_user);
        $model->hapus('user', $sim); 
        
        return redirect()->to('gudang/tampilkaryawan');
}
public function hapus_pelanggan($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_pelanggan' =>$id);
        $chichi['chelsica']=$Sim->hapus('pelanggan',$chiuw);
        return redirect()->to('gudang/tampilpelanggan');
    }
    
public function hapus_pelangganuser($id)
{
    $model = new M_belajar;
    $chiuw = array('id_pelanggan' => $id);
    $pelanggan = $model->getWhere('pelanggan', $chiuw);
        $model->hapus('pelanggan', $chiuw);
        $sim = array('id_user' => $pelanggan->id_user);
        $model->hapus('user', $sim); 
        
        return redirect()->to('gudang/tampilpelanggan');
}
public function hapus_pemesanan($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_pemesanan' =>$id);
        $chichi['chelsica']=$Sim->hapus('pemesanan',$chiuw);
        return redirect()->to('gudang/tampilpemesanan');
    }
















   public function edit_user($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_user' =>$id);
        $chichi['chelsica']=$Sim->getWhere('user',$chiuw);
        echo view('header', $this->data);
        echo view ('menu');
        echo view('euser', $chichi);
        echo view('footer');          
    } 

    public function simpan_user()
	{
		$model= new M_belajar();
		$chiuw= array('id_user' => $this->request->getPost('id'));
		$data = array(
			'username'=> $this->request->getPost('username'),
			'password'=> MD5($this->request->getPost('password')),
			'level'=> $this->request->getPost('level'),
		);
		$model->edit('user',$data,$chiuw);
		return redirect()->to('/gudang/tampiluser');
	}
	public function edit_tipekamar($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_tipe' =>$id);
        $chichi['chelsica']=$Sim->getWhere('tipe_kamar',$chiuw);
        echo view('header', $this->data);
        echo view ('menu');
        echo view('etipekamar', $chichi);
        echo view('footer');          
    } 

    public function simpan_tipekamar()
	{
		$model= new M_belajar();
		$chiuw= array('id_tipe' => $this->request->getPost('id'));
		$data = array(
			'tipe_kamar'=> $this->request->getPost('tipe_kamar'),
			'lokasi'=> $this->request->getPost('lokasi'),
			'harga'=> $this->request->getPost('harga'),
			'orang'=> $this->request->getPost('orang'),
			'foto'=> $this->request->getPost('file'),
		);

        $model = new M_belajar();
		$model->edit('tipe_kamar',$data,$chiuw);
		return redirect()->to('/gudang/tampiltipekamar');
	}
	public function edit_barangk($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_barang_keluar' =>$id);
        $chichi['chelsica']=$Sim->getWhere('barang_keluar',$chiuw);
        echo view('header', $this->data);
        echo view ('menu');
        echo view('ebarangk', $chichi);
        echo view('footer');          
    } 

    public function simpan_barangk()
	{
		$model= new M_belajar();
		$chiuw= array('id_barang_keluar' => $this->request->getPost('id'));
		$data = array(
			'id_barang'=> $this->request->getPost('idbarang'),
			'jumlah'=> $this->request->getPost('jumlah'),
			'tanggal_keluar'=> $this->request->getPost('tanggal'),
		);
		$model->edit('barang_keluar',$data,$chiuw);
		return redirect()->to('/gudang/tampilbarangk');
	}
	
public function edit_karyawan($id)
{
    $Sim = new M_belajar;
    $chiuw = array('karyawan.id_user'=>$id);
    $chichi['chelsica'] = $Sim->joinw('karyawan','user','karyawan.id_user=user.id_user',$chiuw); // Fetch the user data
    echo view('header', $this->data);
    echo view('menu');
    echo view('ekaryawan', $chichi); // Pass the data to the view
    echo view('footer');
}

   public function simpan_karyawan()
{
    $model = new M_belajar();
    $chiuw = array('id_user' => $this->request->getPost('idu'));
    
    $data = array(
        'username' => $this->request->getPost('username'),
        'password' => MD5($this->request->getPost('password')),
        'level' => $this->request->getPost('level')
    );
    $model->edit('user', $data, $chiuw);
   
    $where = array("username" => $this->request->getPost('username'));
    $chichi = $model->getWhere('user', $where); 
    $sim = array('id_karyawan' => $this->request->getPost('id'));

        $data2 = array(
            'id_user' => $chichi->id_user,
            'nama_karyawan' => $this->request->getPost('namakaryawan'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'jam_masuk' => $this->request->getPost('jam_masuk'),
            'jam_keluar' => $this->request->getPost('jam_keluar'),
            'gaji' => $this->request->getPost('gaji'),
        );
        $model->edit('karyawan', $data2, $sim);
    
    return redirect()->to('/gudang/tampilkaryawan');
}

public function edit_pelanggan($id)
{
    $Sim = new M_belajar;
    $chiuw = array('pelanggan.id_user'=>$id);
    $chichi['chelsica'] = $Sim->joinw('pelanggan','user','pelanggan.id_user=user.id_user',$chiuw); // Fetch the user data
    echo view('header', $this->data);
    echo view('menu');
    echo view('epelanggan', $chichi); // Pass the data to the view
    echo view('footer');
}

   public function simpan_pelanggan()
{
    $model = new M_belajar();
    $chiuw = array('id_user' => $this->request->getPost('idu'));
    
    $data = array(
        'username' => $this->request->getPost('username'),
        'password' => MD5($this->request->getPost('password')),
        'level' => $this->request->getPost('level')
    );
    $model->edit('user', $data, $chiuw);
   
    $where = array("username" => $this->request->getPost('username'));
    $chichi = $model->getWhere('user', $where); 
    $sim = array('id_pelanggan' => $this->request->getPost('id'));

        $data2 = array(
            'id_user' => $chichi->id_user,
            'nama_pelanggan' => $this->request->getPost('nama_pelanggan'),
            'no_telp' => $this->request->getPost('no_telp'),
            'no_ktp' => $this->request->getPost('no_ktp'),
        );
        $model->edit('pelanggan', $data2, $sim);
    
    return redirect()->to('/gudang/tampilpelanggan');
}

public function nota($id)
    {
        $Sim = new M_belajar;
        $chiuw= array('id_pemesanan' =>$id);
    	$chichi['chelsica'] = $Sim->joinw('pemesanan','tipe_kamar','pemesanan.id_tipe=tipe_kamar.id_tipe',$chiuw);
        echo view('header', $this->data);
        echo view ('menu');
        echo view('pembayaran', $chichi);
        echo view('footer');          
    } 
    // public function simpan_nota()
	// {
	// 	$model= new M_belajar();
	// 	$data = array(
	// 		'nomor_nota'=> $this->request->getPost('nomor_nota'),
	// 		'total'=> $this->request->getPost('harga'),
	// 		'tanggal'=> $currentDateTime = date('Y-m-d\TH:i'),
	// 		'id_pemesanan'=> $this->request->getPost('id_pemesanan'),
	// 		'bayar'=> $this->request->getPost('uang_bayar'),
	// 		'kembali'=> $this->request->getPost('kembalian')
	// 	);
	// 	$model->input('nota',$data);

	// 	$chiuw = array('id_pemesanan' => $this->request->getPost('id_pemesanan'));

	// 	$data2 = array(
    //          	'status_pesan'=> $this->request->getPost('status')
    //          );
    //          $model->edit('pemesanan',$data2,$chiuw);

	// 	return redirect()->to('gudang/printnota');
	// }
	public function simpan_nota()
{
    $model = new M_belajar;

    // Collect form data
    $data = [
        'nomor_nota'   => $this->request->getPost('nomor_nota'),
        'total'         => $this->request->getPost('harga'),
        'tanggal'       => date('Y-m-d H:i:s'), // Ensure correct datetime format
        'id_pemesanan'  => $this->request->getPost('id_pemesanan'),
        'bayar'         => $this->request->getPost('uang_bayar'),
        'kembali'       => $this->request->getPost('kembalian')
    ];

        $model->input('nota',$data);

        // Update status_pesan in pemesanan table
        $model->edit('pemesanan', ['status_pesan' => 2], ['id_pemesanan' => $this->request->getPost('id_pemesanan')]);

        return redirect()->to(base_url('gudang/printnota'))->with('message', 'Payment recorded successfully');
}




















public function excellapor_nota()
{
		$Sim = new M_belajar;
		$a=$this->request->getPost('tanggal_awal');
		$b=$this->request->getPost('tanggal_akhir');
		$where=('id_nota');
		$chichi['chelsica']=$Sim->filternota('nota','tanggal >=','tanggal <=', $a, $b,$where);
		echo view ('excellapor_nota',$chichi);
}
public function pdflapor_pesanan()
{
    $a = $this->request->getPost('tanggal_awal');
    $b = $this->request->getPost('tanggal_akhir');
   
    $Sim = new M_belajar();
    $chelsica = $Sim->filterpesanan(
        'pemesanan', 
        'kamar', 
        'pelanggan', 
        'karyawan', 
        'tipe_kamar', 
        'pemesanan.id_kamar = kamar.id_kamar', 
        'pemesanan.id_pelanggan = pelanggan.id_pelanggan',
        'pemesanan.id_karyawan = karyawan.id_karyawan',
        'kamar.id_tipe = tipe_kamar.id_tipe',
        'cek_in', $a, $b, 'id_pemesanan'
    );

    $pdf = new TCPDF();
    $pdf->SetCreator('TCPDF');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Laporan Tamu');
    $pdf->SetSubject('Laporan PDF');
    $pdf->SetKeywords('TCPDF, PDF, laporan, tamu');
   $pdf->Image(FCPATH . 'public/img/elysium-logo.png', 10, 10, 50, 50);


    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 8);
    $html = view('pdflapor_pesanan', ['chelsica' => $chelsica]);
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('laporan_tamu_' . date('YmdHis') . '.pdf', 'D'); // 'D' for download
}
// public function pdflapor_pesanan()
// {
//     $a = $this->request->getPost('tanggal_awal');
//     $b = $this->request->getPost('tanggal_akhir');
   
//     $Sim = new M_belajar();
//     $chichi['chelsica'] = $Sim->filterpesanan(
//         'pemesanan', 
//         'kamar', 
//         'pelanggan', 
//         'karyawan', 
//         'tipe_kamar', 
//         'pemesanan.id_kamar = kamar.id_kamar', 
//         'pemesanan.id_pelanggan = pelanggan.id_pelanggan',
//         'pemesanan.id_karyawan = karyawan.id_karyawan',
//         'kamar.id_tipe = tipe_kamar.id_tipe',
//         'cek_in', $a, $b, 'id_pemesanan'
//     );
    
//     $data = [
//         'a' => $a,
//         'b' => $b,
//         'chelsica' => $chichi['chelsica']
//     ];

//     $filename = date('y-m-d-H-i-s'). '-Laporan-Tamu';
//     $dompdf = new Dompdf();
//     $html = view('pdflapor_pesanan', $data);
//     $dompdf->loadHtml($html);
//     $dompdf->setPaper('A4', 'portrait');
//     $dompdf->render();
//     $dompdf->stream($filename);
// }

public function printnota()
{
		$Sim = new M_belajar;
		$where = ('id_nota');
		$chichi['chelsica']=$Sim->join3('nota', 'pemesanan', 'tipe_kamar', 
                   'nota.id_pemesanan = pemesanan.id_pemesanan', 
                   'pemesanan.id_tipe = tipe_kamar.id_tipe',$where);
		echo view ('printnota',$chichi);
}

public function printhistorinota($id_nota)
{
    $Sim = new M_belajar;
    $where=['nota.id_nota' => $id_nota];
    $chichi['chelsica'] = $Sim->join32(
        'nota', 
        'pemesanan', 
        'tipe_kamar',
        'nota.id_pemesanan = pemesanan.id_pemesanan', 
        'pemesanan.id_tipe = tipe_kamar.id_tipe',
        $where
    );

    echo view('printnota', $chichi);
}
}



