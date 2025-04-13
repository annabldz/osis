<?php

namespace App\Controllers;
use TCPDF;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\writer\Xlsx;
use App\Models\M_belajar;

class Home extends BaseController
{
	public function index()
	{
		return view('welcome_message');
	}
	public function userprofile()
	{
		return view('users-profile');
	}
	public function aksi_login ()
	{
		$a=$this->request->getPost('email');
		$b=$this->request->getPost('pswd');

		$love = new M_belajar;
		$data = array(
			"username"=>$a,
			"password"=>MD5($b),
		);

		$cek = $love->getWhere('user',$data);

		if ($cek != null) {

			session()->set('id',$cek->id_user);
			session()->set('u',$cek->username);
			// session()->set('nama',$cek->nama_user);
			session()->set('level',$cek->level);

			return redirect()->to('home/dashboard');
		}else {
			return redirect()->to('home/login');
		}
	}
	public function login()
	{
		
		echo view('login');
	}
	public function logout(){
		session()->destroy();
		return redirect()->to('home/login');
	}

	public function dashboard()
	{
		if (session()->get('id')>0) {
			$joyce= new M_belajar;
			$where=array('id_user' => session()->get('id'));
			$wendy['anjas']=$joyce->getwhere('user',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}

			echo view('header',$hee);
			echo view('menu');
			echo view('dashboard',$wendy);
			echo view('footer');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function user()
	{
		if (session()->get('level')=='1'){  
			$joyce= new M_belajar;
			$where=('id_user');
			$wendy['anjas']=$joyce->tampil('user',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('user',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function userprof()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$where=('id_user');
			$wendy['anjas']=$joyce->tampil('user',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('userprof',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editprof()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$where=('id_user');
			$wendy['anjas']=$joyce->tampil('user',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('editprof',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function edituser ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_user' =>$id);
		$data = array(
			"password"=>MD5('1111'),
		);
		$joyce->edit('user',$data,$wece);
		return redirect()->to('home/user');
		
		
	}
	public function saveuser ()
	{
		$a=$this->request->getPost('username');
		$b=$this->request->getPost('password');
		$c=$this->request->getPost('id');
		$d=$this->request->getPost('level');
		$e=$this->request->getPost('nama');

		$joyce= new M_belajar;
		$wece= array('id_user' =>$c);
		$data = array(
			"username"=>$a,
			"password"=>MD5($b),
			"level"=>$d,
			"nama_user"=>$e,
			
		);
		$joyce->edit('user',$data,$wece);
		return redirect()->to('home/user'); 
	}
	
	// public function inputuser()
	// {
	// 	$joyce= new M_belajar;
	// 	$where=('id_user');
	// 	$wendy['anjas']=$joyce->tampil('user',$where);
	// 	echo view('header');
	// 	echo view('menu');
	// 	echo view('iuser',$wendy);
	// 	echo view('footer');

	// }
	// public function saveiuser ()
	// {
	// 	$a=$this->request->getPost('file');
	// 	$b=$this->request->getPost('username');
	// 	$c=$this->request->getPost('nama');
	// 	$d=$this->request->getPost('password');
	// 	$e=$this->request->getPost('level');

	// 	$data = array(
	// 		"foto"=>$a,
	// 		"username"=>$b,
	// 		"nama_user"=>$c,
	// 		"password"=>$d,
	// 		"level"=>$e,

	// 	);
		
	// 	$file = $_FILES["file"];
	// 	$validExtensions = ["jpg", "png", "jpeg"];
	// 	$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
	// 	$timestamp = time(); 
	// 	$newFileName = $timestamp . "_" . $file["name"]; 
	// 	move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
	// 	$data['foto'] = $newFileName; 

	// 	$joyce= new M_belajar;
	// 	$joyce->input('user',$data);
		
	// 	return redirect()->to('home/user');
	// }

	public function guru()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->join('guru','user','guru.id_user=user.id_user');

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('guru',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editguru ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_guru' =>$id);
		$wendy['anjas']=$joyce->getWhere('guru',$wece);
		$where=('id_guru');
		$wece= array('id_user' =>$id);
		$wendy['user']=$joyce->getWhere('user',$wece);
		$where=('id_user');
		// echo view('header');
		// echo view('menu');
		echo view('editguru',$wendy);
		echo view('footer');
		
	}
	public function saveguru ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('nik');
		$c=$this->request->getPost('id');
		$d=$this->request->getPost('foto');
		$e=$this->request->getPost('user');
		$joyce= new M_belajar;
		$wece= array('id_guru' =>$c);
		$data = array(
			"nama_guru"=>$a,
			"nik"=>$b,
			
		);
		$joyce->edit('guru',$data,$wece);
		$where=array(
			"nama_guru"=>$a,
		);
		$wendy=$joyce->getWhere('guru',$where);
		$were= array('id_guru' =>$c);
		$data2=array(
			"id_user"=>$wendy->id_user,
			"foto"=>$file,
			
		);
		$joyce->edit('user',$data2, $were);	
		return redirect()->to('home/guru');

	}
	public function hapusguru ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_guru' =>$id);
		$wendy['anjas']=$joyce->hapus('guru',$wece);
		return redirect()->to('home/guru');
	}
	public function hapusfoto ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_user' =>$id);
		$wendy['anjas']=$joyce->hapus('user',$wece);
		return redirect()->to('home/userprof');
	}
	public function inputguru ()
	{
		$joyce= new M_belajar;
		$wendy['anjas']=$joyce->join('guru','user','guru.id_user=user.id_user');
		echo view('header');
		echo view('menu');
		echo view('iguru');
		echo view('footer');

	}
	public function saveiguru ()
	{
		$a=$this->request->getPost('file');
		$b=$this->request->getPost('nama');
		$c=$this->request->getPost('nik');
		$d=$this->request->getPost('username');
		$e=$this->request->getPost('user');
		$f=$this->request->getPost('password');
		$g=$this->request->getPost('level');
		
		$joyce= new M_belajar;
		$data = array(
			"foto"=>$a,
			"username"=>$d,
			"nama_user"=>$e,
			"password"=>MD5($f),
			"level"=>$g,
		);
		$file = $_FILES["file"];
		$validExtensions = ["jpg", "png", "jpeg"];
		$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$timestamp = time(); 
		$newFileName = $timestamp . "_" . $file["name"]; 
		move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
		$data['foto'] = $newFileName;

		$joyce->input('user',$data);
		$where=array(
			"username"=>$d,
		);
		$wendy=$joyce->getWhere('user',$where);
		$data2=array(
			"id_user"=>$wendy->id_user,
			"nama_guru"=>$b,
			"nik"=>$c,

		);
		$joyce->input('guru',$data2);	
		return redirect()->to('home/guru');

	}

	public function siswa()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->siswa('siswa','user','rombel','siswa.id_user=user.id_user','siswa.id_rombel=rombel.id_rombel');

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('siswa',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function __construct()
    {
        // Menggunakan Dependency Injection untuk memuat model
        $this->M_belajar = new M_Belajar();
    }
	public function siswakelas()
	{
		 $data['rombel'] = $this->M_belajar->get_all_kelas(); // Ambil semua kelas
        $data['siswa'] = []; // Inisialisasi siswa kosong

        // Cek jika ada input kelas
        if ($this->input->getPost('kelas_id')) {
            $kelas_id = $this->input->getPost('kelas_id');
            $data['siswa'] = $this->M_belajar->get_siswa_by_kelas($kelas_id); // Ambil siswa berdasarkan kelas
        }

        // Load view dan kirimkan data
        return view('siswakelas', $data);
 
	}
	public function editsiswa ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_siswa' =>$id);
		$wendy['anjas']=$joyce->getWhere('siswa',$wece);
		$where=('id_siswa');
		echo view('header');
		echo view('menu');
		echo view('editsiswa',$wendy);
		echo view('footer');
		
	}
	public function savesiswa ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('nis');
		$c=$this->request->getPost('id');
		$d=$this->request->getPost('rombel');

		$joyce= new M_belajar;
		$wece= array('id_siswa' =>$c);
		$data = array(
			"nama_siswa"=>$a,
			"nis"=>$b,
			"id_rombel"=>$d,
			
		);
		$joyce->edit('siswa',$data,$wece);
		return redirect()->to('home/siswa'); 
	}
	public function hapussiswa ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_siswa' =>$id);
		$wendy['anjas']=$joyce->hapus('siswa',$wece);
		return redirect()->to('home/siswa');
	}
	public function inputsiswa ()
	{
		$joyce= new M_belajar;
		$where=('id_siswa');
		$wendy['anjas']=$joyce->tampil('siswa',$where);
		echo view('header');
		echo view('menu');
		echo view('isiswa',$wendy);
		echo view('footer');

	}
	public function saveisiswa ()
	{
		$a=$this->request->getPost('file');
		$b=$this->request->getPost('nama');
		$c=$this->request->getPost('nis');
		$d=$this->request->getPost('username');
		$e=$this->request->getPost('user');
		$f=$this->request->getPost('password');
		$g=$this->request->getPost('level');
		$h=$this->request->getPost('rombel');
		$joyce= new M_belajar;
		$data = array(
			"foto"=>$a,
			"username"=>$d,
			"nama_user"=>$e,
			"password"=>MD5($f),
			"level"=>$g,
			
		);
		$file = $_FILES["file"];
		$validExtensions = ["jpg", "png", "jpeg"];
		$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$timestamp = time(); 
		$newFileName = $timestamp . "_" . $file["name"]; 
		move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
		$data['foto'] = $newFileName;

		$joyce->input('user',$data);
		$where=array(
			"username"=>$d,
		);
		$wendy=$joyce->getWhere('user',$where);
		$data2=array(
			"id_user"=>$wendy->id_user,
			"nama_siswa"=>$b,
			"nis"=>$c,
			"id_rombel"=>$h,

		);
		$joyce->input('siswa',$data2);	
		return redirect()->to('home/siswa');
	}
	public function rombel()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->rombel();


			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('rombel',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editrombel ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_rombel' =>$id);
		$wendy['anjas']=$joyce->getWhere('rombel',$wece);
		$where=('id_rombel');
		echo view('header');
		echo view('menu');
		echo view('editrombel',$wendy);
		echo view('footer');

	}
	public function saverombel ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_rombel' =>$b);
		$data = array(
			"nama_rombel"=>$a,
		);
		$joyce->edit('rombel',$data,$wece);
		return redirect()->to('home/rombel'); 
	}
	public function hapusrombel ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_rombel' =>$id);
		$wendy['anjas']=$joyce->hapus('rombel',$wece);
		return redirect()->to('home/rombel');
	}
	public function inputrombel ()
	{
		$joyce= new M_belajar;
		$where=('id_rombel');
		$wendy['anjas']=$joyce->tampil('rombel',$where);
		$where=('id_jadwal');
		$wendy['love']=$joyce->tampil('jadwal',$where);
		echo view('header');
		echo view('menu');
		echo view('irombel',$wendy);
		echo view('footer');

	}
	public function saveirombel ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('guru');
		$c=$this->request->getPost('kelas');

		$data = array(
			"nama_rombel"=>$a,
			"id_guru"=>$b,
			"id_kelas"=>$c,
		);

		$joyce= new M_belajar;
		$joyce->input('rombel',$data);

		return redirect()->to('home/rombel');
	}
	public function mapel()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$where=('id_mapel');
			$wendy['anjas']=$joyce->tampil('mapel',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('mapel',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editmapel (
	)
	{

		$joyce= new M_belajar;
		$wece= array('id_mapel' =>$id);
		$wendy['anjas']=$joyce->getWhere('mapel',$wece);
		$where=('id_mapel');
		echo view('header');
		echo view('menu');
		echo view('editmapel',$wendy);
		echo view('footer');
		
	}
	public function savemapel ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_mapel' =>$b);
		$data = array(
			"nama_mapel"=>$a,
			
		);
		$joyce->edit('mapel',$data,$wece);
		return redirect()->to('home/mapel'); 
	}
	public function hapusmapel ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_mapel' =>$id);
		$wendy['anjas']=$joyce->hapus('mapel',$wece);
		return redirect()->to('home/mapel');
	}
	public function inputmapel ()
	{
		$joyce= new M_belajar;
		$where=('id_mapel');
		$wendy['anjas']=$joyce->tampil('mapel',$where);
		echo view('header');
		echo view('menu');
		echo view('imapel',$wendy);
		echo view('footer');

	}
	public function saveimapel ()
	{
		$a=$this->request->getPost('nama');
		$data = array(
			"nama_mapel"=>$a,
		);

		$joyce= new M_belajar;
		$joyce->input('mapel',$data);
		
		return redirect()->to('home/mapel');
	}
	public function nilai()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->joinm('nilai','siswa','jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
				'nilai.id_siswa=siswa.id_siswa',
				'jadwal.id_jadwal=nilai.id_jadwal',
				'jadwal.id_rombel=rombel.id_rombel',
				'jadwal.id_mapel=mapel.id_mapel',

				'jadwal.id_guru=guru.id_guru',
				'jadwal.id_blok=blok.id_blok',
				'jadwal.id_semester=semester.id_semester',
				'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran');

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('nilai',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editnilai ($id)
	{

		$joyce= new M_belajar;
		
		$wece= array('id_siswa' =>$id);
		$wendy['siswaa']=$joyce->getWhere('siswa',$wece);
		$where=('id_siswa');

		$wece= array('id_nilai' =>$id);
		$wendy['nilai']=$joyce->getWhere('nilai',$wece);
		$where=('id_nilai');

		echo view('header');
		echo view('menu');
		echo view('editnilai',$wendy);
		echo view('footer');
		
	}
	public function savenilai ()
	{
		$a=$this->request->getPost('siswa');
		$b=$this->request->getPost('pengetahuan');
		$c=$this->request->getPost('keterampilan');
		$d=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_nilai' =>$d);
		$data = array(
			"id_siswa"=>$a,
			"nilai_pengetahuan"=>$b,
			"nilai_keterampilan"=>$c,
		);
		$joyce->edit('nilai',$data,$wece);
		return redirect()->to('home/nilai'); 
	}
	public function hapusnilai ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_nilai' =>$id);
		$wendy['anjas']=$joyce->hapus('nilai',$wece);
		return redirect()->to('home/nilai');
	}
	public function tnilai()
	{
		$joyce= new M_belajar;
		$where=('id_rombel');
		$wendy['rombel']=$joyce->tampil('rombel',$where);
		$where=('id_mapel');
		$wendy['mapel']=$joyce->tampil('mapel',$where);
		$where=('id_siswa');
		$wendy['siswa']=$joyce->tampil('siswa',$where);
		$where=('id_jadwal');
		$wendy['love']=$joyce->tampil('jadwal',$where);
		echo view('header');
		echo view('menu');
		echo view('inputnilai',$wendy);
		echo view('footer');
	}
	public function savetn ()
	{
		$a=$this->request->getPost('siswa');
		$b=$this->request->getPost('pengetahuan');
		$c=$this->request->getPost('keterampilan');
		$d=$this->request->getPost('jadwal');
		$total = ($b + $c / 2);
		$data = array(
			"id_siswa"=>$a,
			"nilai_pengetahuan"=>$b,
			"nilai_keterampilan"=>$c,
			"id_jadwal"=>$d,
			

		);

		$joyce= new M_belajar;
		$joyce->input('nilai',$data);
		return redirect()->to('home/nilai');
	}



	public function jadwal()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->joinn('jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
				'jadwal.id_rombel=rombel.id_rombel',
				'jadwal.id_mapel=mapel.id_mapel',
				'jadwal.id_guru=guru.id_guru',
				'jadwal.id_blok=blok.id_blok',
				'jadwal.id_semester=semester.id_semester',
				'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran');

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('jadwal',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editjadwal ($id)
	{

		$joyce= new M_belajar;
		
		$wece= array('id_guru' =>$id);
		$wendy['guru']=$joyce->getWhere('guru',$wece);
		$where=('id_guru');

		$wece= array('id_jadwal' =>$id);
		$wendy['jadwal']=$joyce->getWhere('jadwal',$wece);
		$where=('id_jadwal');

		echo view('header');
		echo view('menu');
		echo view('editjadwal',$wendy);
		echo view('footer');
		
	}
	public function savejadwal ()
	{
		$a=$this->request->getPost('guru');
		$b=$this->request->getPost('sesi');
		$c=$this->request->getPost('jam');
		$d=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_jadwal' =>$d);
		$data = array(
			"id_guru"=>$a,
			"sesi"=>$b,
			"jam_sesi"=>$c,
		);

		$joyce->edit('jadwal',$data,$wece);
		return redirect()->to('home/jadwal'); 
	}
	public function hapusjadwal ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_jadwal' =>$id);
		$wendy['anjas']=$joyce->hapus('jadwal',$wece);
		return redirect()->to('home/jadwal');
	}
	public function inputjadwal()
	{
		$joyce= new M_belajar;
		$where=('id_rombel');
		$wendy['rombel']=$joyce->tampil('rombel',$where);
		$where=('id_mapel');
		$wendy['mapel']=$joyce->tampil('mapel',$where);
		$where=('id_guru');
		$wendy['guru']=$joyce->tampil('guru',$where);
		$where=('id_blok');
		$wendy['blok']=$joyce->tampil('blok',$where);
		$where=('id_semester');
		$wendy['semester']=$joyce->tampil('semester',$where);
		$where=('id_tahunajaran');
		$wendy['tahun']=$joyce->tampil('tahun_ajaran',$where);
		echo view('header');
		echo view('menu');
		echo view('ijadwal',$wendy);
		echo view('footer');
	}
	public function saveijadwal ()
	{
		$a=$this->request->getPost('rombel');
		$b=$this->request->getPost('mapel');
		$c=$this->request->getPost('guru');
		$d=$this->request->getPost('blok');
		$e=$this->request->getPost('semester');
		$f=$this->request->getPost('tahun');
		$g=$this->request->getPost('sesi');
		$h=$this->request->getPost('jam');
		$data = array(
			"id_rombel"=>$a,
			"id_mapel"=>$b,
			"id_guru"=>$c,
			"id_blok"=>$d,
			"id_semester"=>$e,
			"id_tahunajaran"=>$f,
			"sesi"=>$g,
			"jam_sesi"=>$h,
		);

		$joyce= new M_belajar;
		$joyce->input('jadwal',$data);
		return redirect()->to('home/jadwal');
	}
	public function blok()
	{
		if (session()->get('level')=='1'){ 

			$joyce= new M_belajar;
			$where=('id_blok');
			$wendy['anjas']=$joyce->tampil('blok',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('blok',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editblok ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_blok' =>$id);
		$wendy['anjas']=$joyce->getWhere('blok',$wece);
		$where=('id_blok');
		echo view('header');
		echo view('menu');
		echo view('editblok',$wendy);
		echo view('footer');
		
	}
	public function saveblok ()
	{
		$a=$this->request->getPost('kode');
		$b=$this->request->getPost('id');	

		$joyce= new M_belajar;
		$wece= array('id_blok' =>$b);
		$data = array(
			"kode_blok"=>$a,

		);
		$joyce->edit('blok',$data,$wece);
		return redirect()->to('home/blok'); 
	}
	public function hapusblok ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_blok' =>$id);
		$wendy['anjas']=$joyce->hapus('blok',$wece);
		return redirect()->to('home/blok');
	}
	public function inputblok ()
	{
		$joyce= new M_belajar;
		$where=('id_blok');
		$wendy['anjas']=$joyce->tampil('blok',$where);
		
		echo view('header');
		echo view('menu');
		echo view('iblok',$wendy);
		echo view('footer');

	}
	public function saveiblok ()
	{
		$a=$this->request->getPost('kode');
		$data = array(
			"kode_blok"=>$a,
		);

		$joyce= new M_belajar;
		$joyce->input('blok',$data);
		
		return redirect()->to('home/blok');
	}
	public function kelas()
	{
		if (session()->get('level')=='1'){ 
			$joyce= new M_belajar;
			$where=('id_kelas');
			$wendy['anjas']=$joyce->tampil('kelas',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			echo view('header',$hee);
			echo view('menu');
			echo view('kelas',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editkelas ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_kelas' =>$id);
		$wendy['anjas']=$joyce->getWhere('kelas',$wece);
		$where=('id_kelas');
		echo view('header');
		echo view('menu');
		echo view('editkelas',$wendy);
		echo view('footer');
		
	}
	public function savekelas ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_kelas' =>$b);
		$data = array(
			"nama_kelas"=>$a,
			
		);
		$joyce->edit('kelas',$data,$wece);
		return redirect()->to('home/kelas'); 
	}
	public function hapuskelas ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_kelas' =>$id);
		$wendy['anjas']=$joyce->hapus('kelas',$wece);
		return redirect()->to('home/kelas');
	}
	public function inputkelas ()
	{
		$joyce= new M_belajar;
		$where=('id_kelas');
		$wendy['anjas']=$joyce->tampil('kelas',$where);
		echo view('header');
		echo view('menu');
		echo view('ikelas',$wendy);
		echo view('footer');

	}
	public function saveikelas ()
	{
		$a=$this->request->getPost('nama');
		$data = array(
			"nama_kelas"=>$a,
		);

		$joyce= new M_belajar;
		$joyce->input('kelas',$data);
		
		return redirect()->to('home/kelas');
	}
	public function laporanblok()
	{
		if (session()->get('level')==1 || session()->get('level')==2){ 
			$joyce= new M_belajar;
			$where=('id_nilai');
		    $wendy['nilai']=$joyce->tampil('nilai',$where);
			$where=('id_rombel');
			$wendy['rombel']=$joyce->tampil('rombel',$where);
			$where=('id_siswa');
			$wendy['siswa']=$joyce->tampil('siswa',$where);
		    $where=('id_blok');
		    $wendy['blok']=$joyce->tampil('blok',$where);
		    $where=('id_tahunajaran');
		    $wendy['tahun']=$joyce->tampil('tahun_ajaran',$where);

			if (session()->get('level')==1) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==2) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==2) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			echo view('header',$hee);
			echo view('menu');
			echo view('laporanblok',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function lapblok ()
	{
		$joyce= new M_belajar;
  	    $a=$this->request->getPost('blok');
  	    $b=$this->request->getPost('tahun');
  	    $c=$this->request->getPost('rombel');

  	    if (session()->get('level')==1 || session()->get('level')==2) {
  	    $where=array('siswa.id_rombel');
  	    $wendy['nilai']=$joyce->raport('nilai','siswa','jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
        'nilai.id_siswa=siswa.id_siswa',
        'jadwal.id_jadwal=nilai.id_jadwal',
        'jadwal.id_rombel=rombel.id_rombel',
        'jadwal.id_mapel=mapel.id_mapel',
        'jadwal.id_guru=guru.id_guru',
        'jadwal.id_blok=blok.id_blok',
        'jadwal.id_semester=semester.id_semester',
        'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran',$where);

        $where=array('siswa.id_rombel');
  	    $wendy['raport']=$joyce->joinm('nilai','siswa','jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
				'nilai.id_siswa=siswa.id_siswa',
				'jadwal.id_jadwal=nilai.id_jadwal',
				'jadwal.id_rombel=rombel.id_rombel',
				'jadwal.id_mapel=mapel.id_mapel',

				'jadwal.id_guru=guru.id_guru',
				'jadwal.id_blok=blok.id_blok',
				'jadwal.id_semester=semester.id_semester',
				'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran');

			
    	}
    	 	 // foreach ($siswa as $dom) { 
   		 $dom = new Dompdf();
   		 $dom->loadHtml(view('lapblok',$wendy));
   		 $dom->setPaper('A4','portrait');
   		 $dom->render();
   		 $dom->stream('laporanblok.pdf',array('attachment'=>'false'));
   		//}
   
	}

	public function lapr ()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('blok');
		$b=$this->request->getPost('tahun');
		$b=$this->request->getPost('rombel');
		$wendy['anjas']=$joyce->joinm('nilai','siswa','jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
				'nilai.id_siswa=siswa.id_siswa',
				'jadwal.id_jadwal=nilai.id_jadwal',
				'jadwal.id_rombel=rombel.id_rombel',
				'jadwal.id_mapel=mapel.id_mapel',

				'jadwal.id_guru=guru.id_guru',
				'jadwal.id_blok=blok.id_blok',
				'jadwal.id_semester=semester.id_semester',
				'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran');
		echo view('print',$wendy);
	}
	public function lapb ()
	{
   		$a=$this->request->getPost('blok');
   		$b=$this->request->getPost('tahun');
   		$joyce = new M_belajar;
		$data = array(
			"kode_blok"=>$a,
			"nama_tahun"=>$b,
		);
		$joyce = new M_belajar;
		if (session()->get('level')==1 || session()->get('level')==2) {
				$where=array('nilai.id_jadwal' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('nilai', 'jadwal', 'nilai.id_jadwal=jadwal.id_jadwal',$where);
			}else if (session()->get('level')==1 || session()->get('level')==2) {
				$where=array('nilai.id_siswa' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('nilai', 'siswa', 'nilai.id_siswa=siswa.id_siswa',$where);
			}

   		
		$wendy['nilai']=$joyce->joinm('nilai','siswa','jadwal','rombel','mapel','guru','blok','semester','tahun_ajaran',
				'nilai.id_siswa=siswa.id_siswa',
				'jadwal.id_jadwal=nilai.id_jadwal',
				'jadwal.id_rombel=rombel.id_rombel',
				'jadwal.id_mapel=mapel.id_mapel',

				'jadwal.id_guru=guru.id_guru',
				'jadwal.id_blok=blok.id_blok',
				'jadwal.id_semester=semester.id_semester',
				'jadwal.id_tahunajaran=tahun_ajaran.id_tahunajaran');
		$where=array('siswa.id_rombel' => session()->get('id'));
				$hee['siswa']=$joyce->jwhere1('siswa','rombel','siswa.id_rombel=rombel.id_rombel',$where);
		$where=('id_rombel');
		$wendy['rombel']=$joyce->tampil('rombel',$where);
		$where=('id_jadwal');
		$wendy['jadwal']=$joyce->tampil('jadwal',$where);
		$where=('id_blok');
		$wendy['blok']=$joyce->tampil('blok',$where);
		$where=('id_semester');
		$wendy['semester']=$joyce->tampil('semester',$where);
		$where=('id_tahunajaran');
		$wendy['tahun_ajaran']=$joyce->tampil('tahun_ajaran',$where);
		$where=('id_mapel');
		$wendy['mapel']=$joyce->tampil('mapel',$where);

		// $where=array('id_jadwal' => session()->get('id'));
		// $wendy['jadwal']=$joyce->getWhere('jadwal', $where);
		// $where=array('siswa.id_rombel' => session()->get('id'));
		// $wendy['siswa']=$joyce->jwhere1('siswa', 'rombel', 'siswa.id_rombel=rombel.id_rombel',$where);

   		$dom = new Dompdf();
   		$dom->loadHtml(view('lapblok',$wendy));
   		$dom->setPaper('A4','portrait');
   		$dom->render();
   		$dom->stream('laporanblok.pdf',array('attachment'=>'false'));
		
		
	}
	public function lapblk()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('blok');
		$b=$this->request->getPost('tahun');
		$c=$this->request->getPost('rombel');
		
		

		$dom = new Dompdf();
   		$dom->loadHtml(view('laporblok',$wendy));
   		$dom->setPaper('A4','portrait');
   		$dom->render();
   		$dom->stream('laporanblok.pdf',array('attachment'=>'false'));
	}



	public function lapbd()
	{
		$a=$this->request->getPost('blok');
		$b=$this->request->getPost('tahun');

		$joyce = new M_belajar;
		$data = array(
			"kode_blok"=>$a,
			"nama_tahun"=>$b,
		);

		$wendy['anjas'] = $joyce->joinnw($data);
	}



















	public function editbarang ($id)
	{

		$joyce= new M_belajar;
		$wece= array('id_barang' =>$id);
		$wendy['anjas']=$joyce->getWhere('barang',$wece);
		$where=('id_barang');
		echo view('header');
		echo view('menu');
		echo view('ebarang',$wendy);
		echo view('footer');
		
	}
	public function hapus_barang ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_barang' =>$id);
		$wendy['anjas']=$joyce->hapus('barang',$wece);
		return redirect()->to('home/barang');
	}
	
	public function saveb ()
	{
		$a=$this->request->getPost('kode');
		$b=$this->request->getPost('nama');
		$c=$this->request->getPost('stok');
		$d=$this->request->getPost('id');
		$e=$this->request->getPost('file');

		$joyce= new M_belajar;
		$wece= array('id_barang' =>$d);
		$data = array(
			"kode_barang"=>$a,
			"nama_barang"=>$b,
			"stok"=>$c,
			"foto"=>$d,
		);
		$joyce->edit('barang',$data,$wece);
		return redirect()->to('home/barang');
	}
	public function tb()
	{
		$joyce= new M_belajar;
		$where=('id_barang');
		$wendy['anjas']=$joyce->tampil('barang',$where);
		echo view('header');
		echo view('menu');
		echo view('ibarang',$wendy);
		echo view('footer');

	}
	public function savebrg ()
	{
		if(isset($_POST["hasil"])) {
			$kode = $_POST ["kode"];
			$nama = $_POST ["nama"];
			$stok = $_POST ["stok"];

			$file = $_FILES ["file"]["name"];
			$tmp_name = $_FILES ["file"]["tmp_name"];
			$validImageExtension = ["jpg","png","jpeg"];
			move_uploaded_file($tmp_name, "img/".$file);
		}
		$a=$this->request->getPost('kode');
		$b=$this->request->getPost('nama');
		$c=$this->request->getPost('stok');
		$d=$this->request->getPost('file');
		$data = array(
			"kode_barang"=>$a,
			"nama_barang"=>$b,
			"stok"=>$c,
			"foto"=>$d,

		);
		
		$joyce= new M_belajar;
		$joyce->input('barang',$data);
		
		return redirect()->to('home/barang');
	}


	public function barangm()
	{
		if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')==3 || session()->get('level')==4) {
			$joyce= new M_belajar;
			$wendy['anjas']=$joyce->join('barang_masuk','barang','barang_masuk.id_barang=barang.id_barang');

			echo view('header');
			echo view('menu');
			echo view('barangm',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function edit_barang ($id)
	{
		
		$joyce= new M_belajar;
		$wece= array('id_barang' =>$id);
		$wendy['anjas']=$joyce->getWhere('barang_masuk',$wece);
		echo view('header');
		echo view('menu');
		echo view('barangmas',$wendy);
		echo view('footer');
		
	}
	public function hapusbarang ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_barang' =>$id);
		$wendy['anjas']=$joyce->hapus('barang_masuk',$wece);
		return redirect()->to('home/barangm');
	}
	public function savebm ()
	{
		$a=$this->request->getPost('idb');
		$b=$this->request->getPost('jumlah');
		$c=$this->request->getPost('tanggal');
		$d=$this->request->getPost('idbm');
		$joyce= new M_belajar;
		$wece= array('id_bm' =>$d);
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_masuk"=>$c,
			
		);
		$joyce->edit('barang_masuk',$data,$wece);
		return redirect()->to('home/barangm');
	}
	public function tbm()
	{
		$joyce= new M_belajar;

		$where=('id_bm');
		$wendy['anjas']=$joyce->tampil('barang_masuk',$where);
		echo view('header');
		echo view('menu');
		echo view('tbm',$wendy);
		echo view('footer');
	}
	public function savebmm ()
	{
		$a=$this->request->getPost('id_brg');
		$b=$this->request->getPost('jumlah');
		$c=$this->request->getPost('tanggal');
		$d=$this->request->getPost('file');
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_masuk"=>$c,
			"foto"=>$d,
		);

		$joyce= new M_belajar;
		$joyce->input('barang_masuk',$data);
		return redirect()->to('home/barangm');
	}

	public function laporanm()
	{
		if (session()->get('level')==1 || session()->get('level')==2){ 
			$joyce= new M_belajar;
			$where=('id_bm');
			$wendy['anjas']=$joyce->tampil('barang_masuk',$where);
			echo view('header');
			echo view('menu');
			echo view('laporanm',$wendy);
			echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function lapbm()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_masuk','barang','barang_masuk.id_barang=barang.id_barang','tanggal_masuk >=','tanggal_masuk <=', $a, $b);
		echo view('lapbm',$wendy);
	}

	public function lapbmm()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_masuk','barang','barang_masuk.id_barang=barang.id_barang','tanggal_masuk >=','tanggal_masuk <=', $a, $b);
		echo view('lapbmm',$wendy);
	}


	public function dompdf()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_masuk','barang','barang_masuk.id_barang=barang.id_barang','tanggal_masuk >=','tanggal_masuk <=', $a, $b);

		$dom = new Dompdf();
		$dom->loadHtml(view('lapbrm',$wendy));
		$dom->setPaper('A4','landscape');
		$dom->render();
		$dom->stream('laporan_masuk.pdf',array('attachment'=>0));
		
	}
	
}

// query ambil nama, sama ambil nilai