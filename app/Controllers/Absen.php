<?php

namespace App\Controllers;
use TCPDF;
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

use CodeIgniter\HTTP\Response;
use App\Models\M_absen;
use App\Models\M_absensiswa;
use App\Models\M_libur;
use App\Models\M_absenguru;
use App\Models\M_log;
use App\Models\M_softdelete;
use App\Models\M_web;
use App\Models\UserModel;
use App\Models\M_laporan;
use App\Models\M_user;
use App\Models\M_siswa;
use App\Models\M_gurukartu;
use App\Models\M_deleteguru;
use App\Models\M_deletesiswa;
use App\Models\M_deleteabsenguru;
use App\Models\M_deleteabsensiswa;
use App\Models\M_guru;
use App\Models\M_code;

class absen extends BaseController
{

	public function login()
	{

		echo view('login');
	}  
	public function logout(){
		helper('log'); 
		log_activity(session()->get('id'), 'User logout');

		session()->destroy();
		return redirect()->to('absen/login');
	}
	public function aksi_login()
	{
		helper('log'); // Load helper log_activity
	
		$recaptcha_secret = "6LdyAQUrAAAAAFNzJZVLd1DSWq7lSA5lrhlg8C9t"; // Replace with your actual secret key
		$recaptcha_response = $_POST['g-recaptcha-response'];
	
		// Verify with Google
		$verify_url = "https://www.google.com/recaptcha/api/siteverify";
		$response = file_get_contents($verify_url . "?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
		$response_keys = json_decode($response, true);
	
		if (!$response_keys["success"]) {
			die("reCAPTCHA verification failed. Please try again.");
		}
	
		$a = $this->request->getPost('user');
		$b = $this->request->getPost('pass');
	
		$Joyce = new M_user;
		
		// Cari user berdasarkan username
		$cek = $Joyce->where('username', $a)->first();
	
		// Debugging
		if (!$cek) {
			die("User tidak ditemukan: " . json_encode($a));
		}
	
		// Cek password (pastikan password di database sudah di-hash)
		if ($b !== $cek['password']) {
			die("Username atau password salah!");
		}
	
		// Set session jika login berhasil
		session()->set([
			'id'     => $cek['id_user'],
			'u'      => $cek['username'],
			'level'  => $cek['level'],
			'user_email'  => $cek['email']
		]);
	
		log_activity($cek['id_user'], 'User berhasil login');
		log_message('debug', 'Session setelah login: ' . json_encode(session()->get()));
	
		// Debugging sebelum redirect
		echo "Login berhasil!";
	
		return redirect()->to('absen/dashboard');
	}
	
	
	public function testSession() {
		session()->set('test', 'Session bekerja!');
		echo session()->get('test');
	}
	
	public function dashboard()
	{
		if (session()->get('id')>0) {
			$joyce= new M_absen;
			$where=array('id_user' => session()->get('id'));
			$wendy['anjas']=$joyce->getwhere('user',$where);
			$apel['mey']=$joyce->settings();

			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman Dashboard');
			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('dashboard',$wendy);
			echo view('footer');

		}else{
			return redirect()->to('absen/login');
		}
	}
	public function profile()
	{
		if (session()->get('level')=='1'|| session()->get('level')=='2' || session()->get('level')=='3' || session()->get('level')=='4'){  
			$joyce= new M_absen;
			$apel['mey']=$joyce->settings();

			$wendy['siswa']=$joyce->siswa();
			$wendy['guru']=$joyce->guru();
			$where=('id_user');
			$wendy['id_user']=$joyce->tampil('user', $where);
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman Profile');
			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('profile',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}
	public function user()
	{
		if (session()->get('level')=='1' || session()->get('level')=='4'){  
			$this->logActivity("Mengakses Tabel User");
			$joyce= new M_absen;
			$anna= new M_softdelete;
			$apel['mey']=$joyce->settings();

			$where=('id_user');
			$wendy = [
				'title' => 'Data User',
				'anjas' => $joyce->tampiluser('user', $where),
				'deleted_user' => $anna->getDeletedUser(),
				'showWelcome' => false 
			];
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}
			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman data User');
			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('user',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}
	
	public function edituser ($id)
	{

		$joyce= new M_absen;
		$wece= array('id_user' =>$id);
		$data = array(
			
			"password"=>('1111'),
			
		);
		helper('log');
    		log_activity(session()->get('id'), 'Mereset password user' . $id);
		$joyce->edit('user',$data,$wece);
		return redirect()->to('absen/user');
	}


	public function guru()
	{
	  if (session()->get('level')=='1' || session()->get('level')=='4'){ 
		$joyce= new M_absen;
		$anna= new M_deleteguru;
		$apel['mey']=$joyce->settings();

			  $where=('id_guru');
			  $wendy = [
				  'title' => 'Data Guru',
				  'anjas' => $joyce->guru(),
				  'deleted_user' => $anna->getDeletedGuru(),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('guru',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Guru');
		
	  }else if(session()->get('level')>0){
		return redirect()->to('absen/error');
	  }else{
		return redirect()->to('absen/login');
	  }
	}
		public function editguru ($id)
	{

		$joyce= new M_absen;
		$apel['mey']=$joyce->settings();

		$wece= array('id_guru' =>$id);
		$wendy['anjas']=$joyce->getWhere('guru',$wece);
		$where=('id_guru');
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			
			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('editguru',$wendy);
		echo view('footer');
		
	}
	public function saveguru ()
	{
		$a = $this->request->getPost('nama'); // Nama guru
		$b = $this->request->getPost('nik');  // NIK guru
		$c = $this->request->getPost('id');   // ID guru
		$d = $this->request->getPost('foto'); // Foto (kalau perlu)
		$e = $this->request->getPost('user'); // ID user di tabel `user`
		$userID = session()->get('id');       // ID user yang login
	
		$joyce = new M_absen;
	
		// Update data di tabel guru
		$whereGuru = ['id_guru' => $c];
		$dataGuru = [
			"nama_guru"  => $a,
			"nik"        => $b,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];
		$joyce->edit('guru', $dataGuru, $whereGuru);
	
		// Update data di tabel user
		$whereUser = ['id_user' => $e]; // Gunakan ID user dari guru
		$dataUser = [
			"updated_by" => $userID, // Tambahkan updated_by di user
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at di user
		];
		$joyce->edit('user', $dataUser, $whereUser);
	
		// Simpan log activity
		helper('log');
		log_activity($userID, 'Mengedit data guru ' . $a . ' dengan ID: ' . $c);
	
		return redirect()->to('absen/guru');
	}
	
	// public function hapusguru($id)
	// {
    // 	$joyce = new M_absen;
 	// 	$guru = $joyce->getWhere('guru', ['id_guru' => $id]);

    // 	if ($guru) {
    //     $id_user = $guru->id_user;
    //     $joyce->hapus('guru', ['id_guru' => $id]);
    //     $joyce->hapus('user', ['id_user' => $id_user]);
	// 	helper('log');
	// 	log_activity(session()->get('id'), 'Menghapus data guru dengan ID: ' . $id);
    // }
    // 	return redirect()->to('absen/guru');
	// }
	public function hapusguru($id_guru)
    {
        $joyce = new M_deleteguru();
        $result = $joyce->softDelete($id_guru);
    $userID = session()->get('id');
    helper('log');
    log_activity($userID, "Menghapus data guru dengan ID: " . $id_guru);
        if ($result) {

            return redirect()->to('absen/guru')->with('success', 'User berhasil dihapus (soft delete)');
        } else {
            return redirect()->to('absen/guru')->with('error', 'User tidak ditemukan');
        }
    }

    public function restoreguru($id_guru)
    {
        $joyce = new M_deleteguru();
        $result = $joyce->restore($id_guru);
    $userID = session()->get('id');
    helper('log');
    log_activity($userID, "Merestore data guru dengan ID: " . $id_guru);
        if ($result) {

            return redirect()->to('absen/guru')->with('success', 'User berhasil direstore');
        } else {
            return redirect()->to('absen/guru')->with('error', 'User tidak ditemukan');
        }
    }
	
	public function inputguru ()
	{
		$joyce= new M_absen;
		$where=('id_guru');
		$wendy['guru']=$joyce->tampil('guru',$where);
		$where=('id_user');
		$wendy['user']=$joyce->tampil('user',$where);
		$wendy['iyah']=$joyce->join('guru','user','guru.id_user=user.id_user');
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('inputguru', $wendy);
		echo view('footer');

	}
	public function saveiguru()
	{
		$session = session();
		$userID = $session->get('id'); // Ambil ID user yang sedang login
	
		$a = $this->request->getPost('file');
		$b = $this->request->getPost('nama');
		$c = $this->request->getPost('nik');
		$d = $this->request->getPost('username');
		$e = $this->request->getPost('password');
		$f = $this->request->getPost('level');
		$g = $this->request->getPost('status');
		$h = $this->request->getPost('alamat');
		$i = $this->request->getPost('nomor');
		$j = $this->request->getPost('namauser');
	
		$joyce = new M_absen();
	
		// Data untuk tabel user
		$dataUser = [
			"foto"       => $a,
			"username"   => $d,
			"password"   => $e,
			"level"      => $f,
			"status"     => $g,
			"nama_user"  => $j,
			"created_by" => $userID, // Isi created_by dengan ID user yang login
		];
	
		// Upload Foto
		$file = $_FILES["file"];
		$validExtensions = ["jpg", "png", "jpeg"];
		$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
		$timestamp = time();
		$newFileName = $timestamp . "_" . $file["name"];
		move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
		$dataUser['foto'] = $newFileName;
	
		// Insert data ke tabel user
		$joyce->input('user', $dataUser);
		$id_user = $joyce->insertID(); // Ambil ID user yang baru saja dimasukkan
	
		// Data untuk tabel guru
		$dataGuru = [
			"id_user"    => $id_user,
			"nama_guru"  => $b,
			"nik"        => $c,
			"alamat"     => $h,
			"no_hp"      => $i,
			"created_by" => $userID, // Isi created_by dengan ID user yang login
		];
	
		// Insert data ke tabel guru
		$joyce->input('guru', $dataGuru);
	
		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Menambahkan data guru: " . $b . " dengan ID: " . $id_user);
	
		return redirect()->to('absen/guru');
	}
	

	public function siswa()
	{
	  if (session()->get('level')=='1' || session()->get('level')=='4'){ 
		$joyce= new M_absen;
		$anna= new M_deletesiswa;
		$apel['mey']=$joyce->settings();

			  $where=('id_siswa');
			  $wendy = [
				  'title' => 'Data Siswa',
				  'anjas' => $joyce->siswa(),
				  'deleted_user' => $anna->getDeletedSiswa(),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('siswa',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Siswa');
	  }else if(session()->get('level')>0){
		return redirect()->to('absen/error');
	  }else{
		return redirect()->to('absen/login');
	  }
	}
		public function editsiswa ($id)
	{

		$joyce= new M_absen;
		$wece= array('id_siswa' =>$id);
		$wendy['anjas']=$joyce->getWhere('siswa',$wece);
		$where=('id_siswa');
		$wece= array('id_user' =>$id);
		$wendy['user']=$joyce->getWhere('user',$wece);
		$where=('id_user');
		$where=('id_kelas');
		$wendy['kelas']=$joyce->tampil('kelas',$where);
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('editsiswa',$wendy);
		echo view('footer');
		
	}
	public function savesiswa()
	{
		$a = $this->request->getPost('nama');
		$b = $this->request->getPost('nis');
		$c = $this->request->getPost('id');
		$f = $this->request->getPost('namakelas');
		$userID = session()->get('id');

		$joyce = new M_absen;
		$wece = ['id_siswa' => $c];

		$data = [
			"nama_siswa" => $a,
			"nis" => $b,
			"id_kelas" => $f,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];

		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Mengedit data siswa: " . $a . " dengan ID: " . $c);

		$joyce->edit('siswa', $data, $wece);
		return redirect()->to('absen/siswa');
	}

	// public function hapussiswa($id)
	// {
	// 	$joyce = new M_absen;
	// 	$siswa = $joyce->getWhere('siswa', ['id_siswa' => $id]);
	// 	$userID = session()->get('id');

	// 	if ($siswa) {
	// 		$id_user = $siswa->id_user;

	// 		// Update kolom `deleted_at` dan `deleted_by` sebelum menghapus
	// 		$joyce->edit('siswa', [
	// 			"deleted_by" => $userID,
	// 			"deleted_at" => date('Y-m-d H:i:s')
	// 		], ['id_siswa' => $id]);

	// 		$joyce->hapus('siswa', ['id_siswa' => $id]);
	// 		$joyce->hapus('user', ['id_user' => $id_user]);
	// 	}

	// 	// Simpan log aktivitas
	// 	helper('log');
	// 	log_activity($userID, "Menghapus data siswa dengan ID: " . $id);

	// 	return redirect()->to('absen/siswa');
	// }
	public function hapussiswa($id_siswa)
    {
        $joyce = new M_deletesiswa();
        $result = $joyce->softDelete($id_siswa);
    $userID = session()->get('id');
    helper('log');
    log_activity($userID, "Menghapus data siswa dengan ID: " . $id_siswa);
        if ($result) {

            return redirect()->to('absen/siswa')->with('success', 'User berhasil dihapus (soft delete)');
        } else {
            return redirect()->to('absen/siswa')->with('error', 'User tidak ditemukan');
        }
    }

    public function restoresiswa($id_siswa)
    {
        $joyce = new M_deletesiswa();
        $result = $joyce->restore($id_siswa);
    $userID = session()->get('id');
    helper('log');
    log_activity($userID, "Merestore data siswa dengan ID: " . $id_siswa);
        if ($result) {

            return redirect()->to('absen/siswa')->with('success', 'User berhasil direstore');
        } else {
            return redirect()->to('absen/siswa')->with('error', 'User tidak ditemukan');
        }
    }
	public function inputsiswa ()
	{
		$joyce= new M_absen;
		$where=('id_siswa');
		$wendy['siswa']=$joyce->tampil('siswa',$where);
		$where=('id_user');
		$wendy['user']=$joyce->tampil('user',$where);
		$where=('id_kelas');
		$wendy['kelas']=$joyce->tampil('kelas',$where);
		$wendy['iyah']=$joyce->join2('siswa','user','kelas','siswa.id_user=user.id_user', 'siswa.id_kelas=kelas.id_kelas');
		$apel['mey']=$joyce->settings();


		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('inputsiswa', $wendy);
		echo view('footer');

	}
	public function saveisiswa()
{
	// Validasi password
	$rules = [
		'password' => [
			'label' => 'Password',
			'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/]',
			'errors' => [
				'required' => 'Password wajib diisi.',
				'min_length' => 'Password minimal 8 karakter.',
				'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
			]
		]
	];

	if (!$this->validate($rules)) {
		return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
	}

	$a = $this->request->getPost('file');
	$b = $this->request->getPost('nama');
	$c = $this->request->getPost('nis');
	$d = $this->request->getPost('username');
	$e = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // hash password
	$f = $this->request->getPost('level');
	$g = $this->request->getPost('status');
	$h = $this->request->getPost('alamat');
	$i = $this->request->getPost('nomor');
	$j = $this->request->getPost('kelas');
	$k = $this->request->getPost('namauser');
	$userID = session()->get('id');
	if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $e)) {
		return redirect()->back()->with('error', 'Password tidak memenuhi kriteria keamanan!');
	}
	if (empty($j)) {
		echo "ID Kelas tidak boleh kosong!";
		exit;
	}

	$joyce = new M_absen;
	$data = [
		"foto" => $a,
		"username" => $d,
		"password" => $e,
		"level" => $f,
		"status" => $g,
		"nama_user" => $k,
		"created_by" => $userID,
		"created_at" => date('Y-m-d H:i:s')
	];

	// Upload Foto
	$file = $_FILES["file"];
	$validExtensions = ["jpg", "png", "jpeg"];
	$extension = pathinfo($file["name"], PATHINFO_EXTENSION);
	$timestamp = time();
	$newFileName = $timestamp . "_" . $file["name"];
	move_uploaded_file($file["tmp_name"], "img/" . $newFileName);
	$data['foto'] = $newFileName;

	$joyce->input('user', $data);
	$id_user = $joyce->insertID();

	$data2 = [
		"id_user" => $id_user,
		"nama_siswa" => $b,
		"nis" => $c,
		"alamat" => $h,
		"no_hp" => $i,
		"id_kelas" => $j,
		"created_by" => $userID,
		"created_at" => date('Y-m-d H:i:s')
	];

	// Simpan log aktivitas
	helper('log');
	log_activity($userID, "Menambahkan data siswa: " . $b . " dengan ID: " . $id_user);

	$joyce->input('siswa', $data2);
	return redirect()->to('absen/siswa');
}


	public function kelas()
  {
    if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')=='4'){ 
      $joyce= new M_absen;
      $where=('id_kelas');
      $wendy['kelas'] = $joyce->tampil('kelas',$where); // Ambil semua data kelas
	  $apel['mey']=$joyce->settings();

	  if (session()->get('level')==2) {
		$where=array('guru.id_user' => session()->get('id'));
		$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
	}else if (session()->get('level')==1 || session()->get('level')=='4') {
		$where=array('id_user' => session()->get('id'));
		$hee['prof']=$joyce->getWhere('user', $where);
	}else if (session()->get('level')==3) {
		$where=array('siswa.id_user' => session()->get('id'));
		$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
	}


			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman Kelas');
			$data = array_merge($apel, $hee);
			echo view('header',$data);
      echo view('menu');
      echo view('filterkelas', $wendy);
      echo view('footer');

    }else if(session()->get('level')>0){
      return redirect()->to('absen/error');
    }else{
      return redirect()->to('absen/login');
    }
  }

  public function hasilkelas()
{
    $a = $this->request->getGet('kelass'); // Ambil ID kelas dari form
    $joyce = new M_absen(); // Pastikan Model sudah dipanggil
	$apel['mey']=$joyce->settings();

    $wendy['siswa'] = $joyce->filterkelas($a);
	if (!$a) {
        session()->setFlashdata('pesan', 'Pilih kelas terlebih dahulu');
    }
	if (session()->get('level')==2) {
		$where=array('guru.id_user' => session()->get('id'));
		$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
	}else if (session()->get('level')==1 || session()->get('level')=='4') {
		$where=array('id_user' => session()->get('id'));
		$hee['prof']=$joyce->getWhere('user', $where);
	}else if (session()->get('level')==3) {
		$where=array('siswa.id_user' => session()->get('id'));
		$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
	}


			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman data Kelas' . $a);
			$data = array_merge($apel, $hee);
			echo view('header',$data);
    echo view('kelasfilter', $wendy);
}
	public function inputkelas ()
	{
		$joyce= new M_absen;
		$apel['mey']=$joyce->settings();

		$where=('id_kelas');
		$wendy['kelas']=$joyce->tampil('kelas',$where);
		$where=('id_guru');
		$wendy['wali']=$joyce->tampil('guru',$where);
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('inputkelas', $wendy);
		echo view('footer');

	}
	public function saveikelas()
	{
		$a = $this->request->getPost('id');
		$b = $this->request->getPost('nama');
		$c = $this->request->getPost('walkel');
		$userID = session()->get('id'); // Ambil ID user yang sedang login
	
		$joyce = new M_absen;
		$data = [
			"nama_kelas" => $b,
			"id_guru" => $c,
			"created_by" => $userID, // Tambahkan created_by
			"created_at" => date('Y-m-d H:i:s') // Tambahkan created_at
		];
	
		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Menambahkan data Kelas: " . $b . " dengan ID: " . $a);
	
		$joyce->input('kelas', $data);  
		return redirect()->to('absen/kelas');
	}	

		public function mapel()
	{
		if (session()->get('level')=='1'){  
			$joyce= new M_absen;
			$where=('id_mapel');
			$wendy['anjas']=$joyce->tampil('mapel',$where);

			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}

			echo view('header',$hee);
			echo view('mapel',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}

	public function editmapel ($id)
	{

		$joyce= new M_absen;
		$wece= array('id_mapel' =>$id);
		$wendy['anjas']=$joyce->getWhere('mapel',$wece);
		$where=('id_mapel');

		if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			} 
		echo view('header', $hee);
		echo view('menu');
		echo view('editmapel',$wendy);
		echo view('footer');
		
	}
	public function savemapel ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('id');

		$joyce= new M_absen;
		$wece= array('id_mapel' =>$b);
		$data = array(
			"nama_mapel"=>$a,
		);
		$joyce->edit('mapel',$data,$wece);
		return redirect()->to('absen/mapel');

	}
	public function hapusmapel($id)
	{
    	$joyce= new M_absen;
		$wece= array('id_mapel' =>$id);
		$wendy['anjas']=$joyce->hapus('mapel',$wece);
		return redirect()->to('absen/mapel');
    }

	public function inputmapel ()
	{
		$joyce= new M_absen;
		$where=('id_mapel');
		$wendy['mapel']=$joyce->tampil('mapel',$where);

		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


		echo view('header', $hee);
		echo view('menu');
		echo view('inputmapel', $wendy);
		echo view('footer');

	}
	public function saveimapel ()
	{
		$a=$this->request->getPost('id');
		$b=$this->request->getPost('nama');

		$joyce= new M_absen;
		$data = array(
			"nama_mapel"=>$b,
		);

		$joyce->input('mapel',$data);	
		return redirect()->to('absen/mapel');

	}

	// public function jadwal()
	// {
	// 	if (session()->get('level')=='1'){ 
	// 		$joyce= new M_absen;
	// 		$wendy['anjas']=$joyce->join3();

	// 		if (session()->get('level')==2) {
	// 			$where=array('guru.id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
	// 		}else if (session()->get('level')==1) {
	// 			$where=array('id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->getWhere('user', $where);
	// 		}else if (session()->get('level')==3) {
	// 			$where=array('siswa.id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
	// 		} 
	// 		echo view('header',$hee);
	// 		echo view('menu');
	// 		echo view('jadwal',$wendy);
	// 		echo view('footer');
	// 	}else if(session()->get('level')>0){
	// 		return redirect()->to('absen/error');
	// 	}else{
	// 		return redirect()->to('absen/login');
	// 	}
	// }
	// public function editjadwal ($id)
	// {
	// 	$joyce= new M_absen;    
	// 	$wendy['mapel2'] = $joyce->tampil('mapel', 'id_mapel');
    // 	$wendy['guru2'] = $joyce->tampil('guru', 'id_guru');
    // 	$wendy['kelas2'] = $joyce->tampil('kelas', 'id_kelas');

    // 	// Ambil data jadwal berdasarkan ID
    // 	$wece = ['id_jadwal' => $id];
    // 	$wendy['jadwal'] = $joyce->getWhere('jadwal', $wece);

    // 	if (!$wendy['jadwal']) {
    // 	    return redirect()->to('absen/jadwal')->with('error', 'Jadwal tidak ditemukan');
    // 	}
     		
	// 	if (session()->get('level')==2) {
	// 			$where=array('guru.id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
	// 		}else if (session()->get('level')==1) {
	// 			$where=array('id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->getWhere('user', $where);
	// 		}else if (session()->get('level')==3) {
	// 			$where=array('siswa.id_user' => session()->get('id'));
	// 			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
	// 		} 
	// 	echo view('header', $hee);
	// 	echo view('menu');
	// 	echo view('editjadwal',$wendy);
	// 	echo view('footer');
		
	// }
	// public function savejadwal ()
	// {
	// 	$a=$this->request->getPost('mapel');
	// 	$b=$this->request->getPost('kelas');
	// 	$c=$this->request->getPost('guru');
	// 	$d=$this->request->getPost('hari');
	// 	$e=$this->request->getPost('mulai');
	// 	$f=$this->request->getPost('selesai');
	// 	$g=$this->request->getPost('id');
	// 	$h=$this->request->getPost('idkelas');
	// 	$i=$this->request->getPost('idguru');
	// 	$j=$this->request->getPost('idmapel');

	// 	$joyce= new M_absen;
	// 	$data = array(
    //     "id_mapel"   => $a,
    //     "id_kelas"   => $b,
    //     "id_guru"    => $c,
    //     "hari"       => $d,
    //     "jam_mulai"  => $e,
    //     "jam_selesai"=> $f
    // 	);
    
    // 	$where = array('id_jadwal' => $g);
    // 	$joyce->edit('jadwal', $data, $where);
    
    // 	return redirect()->to('absen/jadwal');
	// }
	
	// public function hapusjadwal ($id)
	// {
	// 	$joyce= new M_absen;
	// 	$wece= array('id_jadwal' =>$id);
	// 	$wendy['anjas']=$joyce->hapus('jadwal',$wece);
	// 	return redirect()->to('absen/jadwal');
	// }
	// public function inputjadwal()
	// {
	// 	$joyce= new M_absen;
	// 	$where=('id_rombel');
	// 	$wendy['rombel']=$joyce->tampil('rombel',$where);
	// 	$where=('id_mapel');
	// 	$wendy['mapel']=$joyce->tampil('mapel',$where);
	// 	$where=('id_guru');
	// 	$wendy['guru']=$joyce->tampil('guru',$where);
	// 	$where=('id_blok');
	// 	$wendy['blok']=$joyce->tampil('blok',$where);
	// 	$where=('id_semester');
	// 	$wendy['semester']=$joyce->tampil('semester',$where);
	// 	$where=('id_tahunajaran');
	// 	$wendy['tahun']=$joyce->tampil('tahun_ajaran',$where);
	// 	echo view('header');
	// 	echo view('menu');
	// 	echo view('ijadwal',$wendy);
	// 	echo view('footer');
	// }
	// public function saveijadwal ()
	// {
	// 	$a=$this->request->getPost('rombel');
	// 	$b=$this->request->getPost('mapel');
	// 	$c=$this->request->getPost('guru');
	// 	$d=$this->request->getPost('blok');
	// 	$e=$this->request->getPost('semester');
	// 	$f=$this->request->getPost('tahun');
	// 	$g=$this->request->getPost('sesi');
	// 	$h=$this->request->getPost('jam');
	// 	$data = array(
	// 		"id_rombel"=>$a,
	// 		"id_mapel"=>$b,
	// 		"id_guru"=>$c,
	// 		"id_blok"=>$d,
	// 		"id_semester"=>$e,
	// 		"id_tahunajaran"=>$f,
	// 		"sesi"=>$g,
	// 		"jam_sesi"=>$h,
	// 	);

	// 	$joyce= new M_belajar;
	// 	$joyce->input('jadwal',$data);
	// 	return redirect()->to('home/jadwal');
	// }

	public function absensiswa()
	{
		if (session()->get('level') == '1' || session()->get('level') == '2' || session()->get('level') == '3' || session()->get('level')=='4') { 
			$joyce = new M_absen;		
			$apel['mey']=$joyce->settings();

			// Kalau siswa, ambil data absensi khusus untuk dia
			if (session()->get('level') == 3) {
				$where = array(
					'siswa.id_user' => session()->get('id'),
					'absensi_siswa.kondisi' => 0 // hanya yang belum dihapus
				);
				$wendy['anjas'] = $joyce->db->table('absensi_siswa')
											->join('siswa', 'absensi_siswa.id_siswa = siswa.id_siswa')
											->join('kelas', 'siswa.id_kelas = kelas.id_kelas')
											->join('user', 'siswa.id_user = user.id_user')
											->select('siswa.id_user, siswa.nama_siswa, siswa.nis, kelas.nama_kelas, absensi_siswa.id_absensiswa, absensi_siswa.tanggal, absensi_siswa.jam_masuk, absensi_siswa.jam_pulang, absensi_siswa.status')
											->where($where)
											->get()->getResult();			
			} else {
				
				$anna= new M_deleteabsensiswa;
				$where=('id_absensiswa');
				$wendy = [
					'title' => 'Data Absen Siswa',
					'anjas' => $joyce->absensiswa2(),
					'deleted_user' => $anna->getDeletedAbsensi(),
					'showWelcome' => false 
			];
			}
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('menu');
			echo view('absensiswa', $wendy);
			echo view('footer');
		} else {
			return redirect()->to('absen/error');
		}
	}	
	public function hapusAbsensiSiswa($id_absensiswa)
	{
		$model = new M_deleteabsensiswa();
		$result = $model->softDelete($id_absensiswa);

		if ($result) {
			helper('log');
			log_activity(session()->get('id'), 'Menghapus data absensi siswa ID: ' . $id_absensiswa);
			return redirect()->to('/absen/absensiswa')->with('success', 'Data absensi berhasil dihapus.');
		} else {
			return redirect()->to('/absen/absensiswa')->with('error', 'Data absensi gagal dihapus.');
		}
	}

	public function restoreAbsensiSiswa($id_absensiswa)
	{
		$model = new M_deleteabsensiswa();
		$result = $model->restore($id_absensiswa);

		if ($result) {
			helper('log');
			log_activity(session()->get('id'), 'Merestore data absensi siswa ID: ' . $id_absensiswa);
			return redirect()->to('/absen/absensiswa')->with('success', 'Data absensi berhasil direstore.');
		} else {
			return redirect()->to('/absen/absensiswa')->with('error', 'Data absensi gagal direstore.');
		}
	}

	public function editabsensiswa ($id)
	{

		$joyce= new M_absen;  
		$apel['mey']=$joyce->settings();
    	$wewe = ['id_siswa' => $id];
    	$wendy['siswa'] = $joyce->getWhere('siswa', $wewe);
    	$weve = ['id_kelas' => $id];
    	$wendy['kelas2'] = $joyce->getWhere('kelas', $weve);
		$were = ['id_jadwal' => $id];
    	$wendy['jadwal'] = $joyce->getWhere('jadwal', $were);

    	$wece = ['id_absensiswa' => $id];
    	$wendy['absensiswa'] = $joyce->getWhere('absensi_siswa', $wece);

    	if (!$wendy['absensiswa']) {
    	    return redirect()->to('absen/absensiswa')->with('error', 'Jadwal tidak ditemukan');
    	}
     		
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('editabsensiswa',$wendy);
		echo view('footer');
		
	}
	public function saveabsensiswa()
	{
		$f = $this->request->getPost('jam');
		$g = $this->request->getPost('status');
		$h = $this->request->getPost('idabsen');
		$userID = session()->get('id'); // ID user yang login
	
		$joyce = new M_absen;
		$data = [
			"jam_absen" => $f,
			"status" => $g,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];
		
		$where = ['id_absensiswa' => $h];
		$joyce->edit('absensi_siswa', $data, $where);
	
		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Mengedit data absensi siswa dengan ID absen: " . $h);
	
		return redirect()->to('absen/absensiswa');
	}
	

	public function absenguru()
	{
		if (session()->get('level') == '1' || session()->get('level') == '2' || session()->get('level')=='4') { 
			$joyce = new M_absen;
			$anna= new M_deleteabsenguru;
			$apel['mey']=$joyce->settings();
			$where=('id_absenguru');
			$wendy = [
				'title' => 'Data Absen Guru',
				'anjas' => $joyce->absenguru2(session()->get('id'), session()->get('level')),
				'deleted_user' => $anna->getDeletedAbsensi(),
				'showWelcome' => false 
			];
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('menu');
			echo view('absenguru', $wendy);
			echo view('footer');
		} else {
			return redirect()->to('absen/error');
		}
	}
	public function hapusAbsensiGuru($id_absenguru)
	{
		$model = new M_deleteabsenguru();
		$result = $model->softDelete($id_absenguru);

		if ($result) {
			helper('log');
			log_activity(session()->get('id'), 'Menghapus data absensi guru ID: ' . $id_absenguru);
			return redirect()->to('/absen/absenguru')->with('success', 'Data absensi berhasil dihapus.');
		} else {
			return redirect()->to('/absen/absenguru')->with('error', 'Data absensi gagal dihapus.');
		}
	}

	public function restoreAbsensiGuru($id_absenguru)
	{
		$model = new M_deleteabsenguru();
		$result = $model->restore($id_absenguru);

		if ($result) {
			helper('log');
			log_activity(session()->get('id'), 'Merestore data absensi guru ID: ' . $id_absenguru);
			return redirect()->to('/absen/absenguru')->with('success', 'Data absensi berhasil direstore.');
		} else {
			return redirect()->to('/absen/absenguru')->with('error', 'Data absensi gagal direstore.');
		}
	}


		public function editabsenguru ($id)
	{
		$joyce= new M_absen; 
		$apel['mey']=$joyce->settings();

		$wee = ['id_mapel' => $id];
    	$wendy['mapel2'] = $joyce->getWhere('mapel', $wee);
    	$wewe = ['id_guru' => $id];
    	$wendy['guru2'] = $joyce->getWhere('guru', $wewe);
    	$weve = ['id_kelas' => $id];
    	$wendy['kelas2'] = $joyce->getWhere('kelas', $weve);
		$were = ['id_jadwal' => $id];
    	$wendy['jadwal'] = $joyce->getWhere('jadwal', $were);

    	$wece = ['id_absenguru' => $id];
    	$wendy['absenguru'] = $joyce->getWhere('absensi_guru', $wece);

    	if (!$wendy['absenguru']) {
    	    return redirect()->to('absen/absenguru')->with('error', 'Jadwal tidak ditemukan');
    	}
     	
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('menu');
		echo view('editabsenguru',$wendy);
		echo view('footer');
		
	}
	public function saveabsenguru()
	{
		$a = $this->request->getPost('jam');
		$b = $this->request->getPost('status'); // Perbaiki typo di sini
		$h = $this->request->getPost('idabsen');
		$userID = session()->get('id'); // ID user yang login

		$joyce = new M_absen;
		$data = [
			"jam_absen" => $a,
			"status" => $b,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];
		
		$where = ['id_absenguru' => $h];
		$joyce->edit('absensi_guru', $data, $where);

		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Mengedit data Absensi Guru dengan ID absen: " . $h);

		return redirect()->to('absen/absenguru');
	}


	public function laporan()
	{
		if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')=='4'){ 
			$joyce= new M_absen;
			$apel['mey']=$joyce->settings();
			$where=('id_absenguru');
		    $wendy['absenguru']=$joyce->absenguru();
			$where=('id_absensiswa');
			$wendy['absensiswa']=$joyce->absensiswa();
			$where=('id_jadwal');
			$wendy['jadwal']=$joyce->join3();
			$where=('id_kelas');
		    $wendy['kelas']=$joyce->tampil('kelas',$where);
			$where=('id_guru');
		    $wendy['guru']=$joyce->tampil('guru',$where);
		   
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('menu');
			echo view('laporan',$wendy);
			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman pembuatan laporan absensi');
		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}

	public function laporansiswa()
	{
		
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$c=$this->request->getPost('kelas');
		if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')==4) {
		$joyce= new M_laporan;
		$wendy['anjas']=$joyce->filtersiswa($c, $a, $b);
		helper('log');
    		log_activity(session()->get('id'), 'Mengakses laporan Absensi Siswa kelas:' . $c . 
			'dari Tanggal' . $a . 'sampai Tanggal' . $b);
		}

		$dom = new Dompdf();
		$dom->loadHtml(view('laporansiswa', $wendy));
		$dom->setPaper('A4','landscape');
		$dom->render();
		$dom->stream('siswa.pdf',array('attachment'=>0));
		
	}

	public function excelsiswa()
	{
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$c=$this->request->getPost('kelas');
		if (session()->get('level')==1 || session()->get('level')==2) {
		$joyce= new M_laporan;
		$wendy['anjas']=$joyce->filtersiswa($c, $a, $b);
		helper('log');
		log_activity(session()->get('id'), 'Mengakses laporan Absensi Siswa kelas:' . $c . 
		'dari Tanggal' . $a . 'sampai Tanggal' . $b);

		// Load view sebagai template HTML
		$html = view('excelsiswa', $wendy);

		// Buat objek Spreadsheet
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->setCellValue('A1', 'LAPORAN ABSENSI SISWA');
		$sheet->mergeCells('A1:D1'); // Gabungkan sel untuk judul
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Atur gaya huruf
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// 🔹 Tambahkan Header Tabel
		$sheet->setCellValue('A3', 'Nama Siswa');
		$sheet->setCellValue('B3', 'Kelas');
		$sheet->setCellValue('C3', 'Tanggal');
		$sheet->setCellValue('D3', 'Status');

		// Buat header bold
		$sheet->getStyle('A3:E3')->getFont()->setBold(true);
		$sheet->getStyle('A3:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$row = 5;

		foreach ($wendy['anjas'] as $data) {
			$sheet->setCellValue('A' . $row, $data->nama_siswa);
			$sheet->setCellValue('B' . $row, $data->nama_kelas);
			$sheet->setCellValue('C' . $row, $data->tanggal);
			$sheet->setCellValue('D' . $row, $data->status);
			$row++;
		}
		foreach (range('A', 'E') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		// Atur header untuk file Excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="siswa.xlsx"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;

		}
	}

	public function laporanguru()
	{
		
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$c=$this->request->getPost('namaguru');
		if (session()->get('level')==1 || session()->get('level')==2) {
		$joyce= new M_laporan;
		$wendy['anjas']=$joyce->filterguru($c, $a, $b);
		}

		$dom = new Dompdf();
		$dom->loadHtml(view('laporanguru',$wendy));
		$dom->setPaper('A4','landscape');
		$dom->render();
		$dom->stream('guru.pdf',array('attachment'=>0));
		helper('log');
		log_activity(session()->get('id'), 'Mengakses laporan Absensi Guru bernama:' . $c . 
		'dari Tanggal' . $a . 'sampai Tanggal' . $b);
	
	}

	public function excelguru()
	{
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$c=$this->request->getPost('namaguru');

		$joyce = new M_laporan;
		$wendy['anjas']=$joyce->filterguru($c, $a, $b);
		helper('log');
		log_activity(session()->get('id'), 'Mengakses laporan Absensi Guru bernama:' . $c . 
		'dari Tanggal' . $a . 'sampai Tanggal' . $b);

		$html = view('excelguru', $wendy);

		$spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul laporan
        $sheet->setCellValue('A1', 'LAPORAN ABSENSI GURU');
        $sheet->mergeCells('A1:E1'); // Gabungkan sel untuk judul
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // 🔹 Tambahkan Header Tabel
        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama Guru');
        $sheet->setCellValue('C3', 'NIK');
        $sheet->setCellValue('D3', 'Tanggal Absensi');
        $sheet->setCellValue('E3', 'Status');

        // Buat header bold
        $sheet->getStyle('A3:E3')->getFont()->setBold(true);
        $sheet->getStyle('A3:E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $row = 4;
        $no = 1;

        foreach ($wendy['anjas'] as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data->nama_guru);
            $sheet->setCellValue('C' . $row, $data->nik);
            $sheet->setCellValue('D' . $row, $data->tanggal);
            $sheet->setCellValue('E' . $row, $data->status);
            $row++;
        }

        // Atur ukuran kolom otomatis
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Atur header untuk file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="guru.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    
	}
	public function generateqr()
	{

		$joyce = new M_absen;
		
		$where = ('id_siswa');
		$wendy['siswa']=$joyce->tampil('siswa', $where);
		$where = ('id_guru');
		$wendy['guru']=$joyce->tampil('guru', $where);

		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}



		echo view('header',$hee);
		echo view('menu');
		echo view('generateqr', $wendy);
		echo view('footer');
	}

	public function generatesiswa($nis)
	{
		$joyce = new M_code;
		$nana = new M_absen;

		$apel['mey']=$nana->settings();
		$user = $joyce->getUserByNIS($nis);
	
		if (!$user) {
			return "User tidak ditemukan.";
		}
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$nana->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$nana->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$nana->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}

		// Buat QR Code
		$qrCode = QrCode::create($nis)
			->setEncoding(new Encoding('UTF-8'))
			->setSize(300)
			->setMargin(10);
	
		// Simpan QR Code ke dalam file
		$writer = new PngWriter();
		$result = $writer->write($qrCode);
	
		// Simpan di public/img/
		$fileName = 'qrcode_' . $nis . '.png';
		$filePath = FCPATH . 'img/qrcode_' . $nis . '.png'; // Simpan di public/img/
	
		$result->saveToFile($filePath);
	
		// Update database
		$joyce->updateQrCode($nis, $fileName);
	
		// **Ambil ulang data terbaru setelah update**
		$user = $joyce->getUserByNIS($nis);
		helper('log');
		log_activity(session()->get('id'), 'Mengakses QR absensi siswa dengan NIS:' . $nis);
		$data = array_merge($apel, $hee);
		echo view('header',$data);
		echo view('generatesiswa', ['anjas' => $user]);
	}
	public function generateguru($nik)
	{
		$joyce = new M_guru;
		$nana = new M_absen;

		$apel['mey']=$nana->settings();
		$user = $joyce->getUserByNIK($nik);
	
		if (!$user) {
			return "User tidak ditemukan.";
		}
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$nana->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$nana->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$nana->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}
		// Buat QR Code
		$qrCode = QrCode::create($nik)
			->setEncoding(new Encoding('UTF-8'))
			->setSize(300)
			->setMargin(10);
	
		// Simpan QR Code ke dalam file
		$writer = new PngWriter();
		$result = $writer->write($qrCode);
	
		// Simpan di public/img/
		$fileName = 'qrcode_' . $nik . '.png';
		$filePath = FCPATH . 'img/qrcode_' . $nik . '.png'; // Simpan di public/img/
	
		$result->saveToFile($filePath);
	
		// Update database
		$joyce->updateQRguru($nik, $fileName);
	
		// **Ambil ulang data terbaru setelah update**
		$user = $joyce->getUserByNIK($nik);

		helper('log');
		log_activity(session()->get('id'), 'Mengakses QR absensi guru dengan NIS:' . $nik);
		$data = array_merge($apel, $hee);
		echo view('header',$data);
		echo view('generateguru', ['anjas' => $user]);
	}
	public function absensi ()
	{

		$joyce = new M_absen;
		$apel['mey']=$joyce->settings();
		// if (session()->get('level')==2) {
		// 	$where=array('guru.id_user' => session()->get('id'));
		// 	$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		// }else if (session()->get('level')==1 || session()->get('level')=='4') {
		// 	$where=array('id_user' => session()->get('id'));
		// 	$hee['prof']=$joyce->getWhere('user', $where);
		// }else if (session()->get('level')==3) {
		// 	$where=array('siswa.id_user' => session()->get('id'));
		// 	$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		// }

		echo view('absensi', $apel);
	}
	public function absensi2 ()
	{
		$joyce = new M_absen;
		$apel['mey']=$joyce->settings();

			echo view('absensi2', $apel);
	}
	
	public function scansiswa()
	{
		$json = $this->request->getJSON();
		log_message('error', 'Data JSON diterima: ' . json_encode($json));
	
		$qrData = $json->qr_data ?? '';
		if (!$qrData) {
			return $this->response->setJSON(['success' => false, 'message' => 'QR Code tidak valid']);
		}
	
		$joyce = new M_code;
		$nana = new M_absensiswa;
	
		$tanggal = date('Y-m-d');
		$jam_absen = date('H:i:s');
		$jam_sekarang = strtotime($jam_absen);
		log_message('error', 'Sekarang jam: ' . $jam_absen);
		log_message('error', 'Tanggal yang digunakan: ' . $tanggal);
	
		// 🛑 Validasi Hari Libur (Minggu/libur nasional)
		$hari = date('w'); // 0 = Minggu, 6 = Sabtu
		if ($hari == 0) {
			return $this->response->setJSON(['success' => false, 'message' => 'Hari ini adalah hari libur.']);
		}
	
		// Cek hari libur dari tabel
		$libur = $joyce->table('libur')
			->where('tanggal', $tanggal)
			->get()
			->getRow();
		if ($libur) {
			return $this->response->setJSON(['success' => false, 'message' => 'Hari ini libur: ' . $libur->keterangan . '. Tidak perlu absen.']);
		}
	
		// Cari siswa berdasarkan NIS
		$siswa = $joyce->table('siswa')->where('nis', $qrData)->get()->getRow();
		if (!$siswa) {
			return $this->response->setJSON(['success' => false, 'message' => 'Siswa tidak ditemukan']);
		}
	
		// Cek apakah siswa sudah absen hari ini
		$existing = $nana->where('id_siswa', $siswa->id_siswa)
			->where('tanggal', $tanggal)
			->first();
	
		if ($existing) {
			// Sudah absen → proses absen pulang
			if ($jam_sekarang >= strtotime('18:00:00') && $jam_sekarang <= strtotime('21:00:00')) {
				$updateData = [
					'jam_pulang' => $jam_absen,
					'updated_at' => date('Y-m-d H:i:s'),
					'updated_by' => session()->get('id')
				];
				log_message('error', 'Isi updateData: ' . json_encode($updateData));
				$nana->update($existing['id_absensiswa'], $updateData);
	
				helper('log');
				log_activity(session()->get('id'), 'Absensi pulang ID Siswa: ' . $siswa->id_siswa);
				return $this->response->setJSON(['success' => true, 'message' => 'Absensi pulang berhasil!']);
			} else {
				return $this->response->setJSON(['success' => false, 'message' => 'Absen pulang hanya boleh antara 18:00 - 21:00']);
			}
		} else {
			// Belum absen → proses absen masuk
			
			if ($jam_sekarang >= strtotime('07:00:00') && $jam_sekarang <= strtotime('15:00:00')) {
				$status = 'Hadir';
			} elseif ($jam_sekarang >= strtotime('16:00:00') && $jam_sekarang <= strtotime('18:00:00')) {
				$status = 'Terlambat';
			} else {
				return $this->response->setJSON(['success' => false, 'message' => 'Absen masuk hanya boleh antara 07:00 - 15:00 atau 16:00 - 18:00']);
			}
	
			$data = [
				'id_siswa' => $siswa->id_siswa,
				'tanggal' => $tanggal,
				'jam_masuk' => $jam_absen,
				// 'jam_absen' => $jam_absen,
				'status' => $status,
				'created_at' => date('Y-m-d H:i:s'),
				'created_by' => session()->get('id')
			];
			$nana->save($data);
	
			helper('log');
			log_activity(session()->get('id'), 'Absensi masuk ID Siswa: ' . $siswa->id_siswa . ' dengan status ' . $status);
			return $this->response->setJSON(['success' => true, 'message' => 'Absensi masuk berhasil dengan status: ' . $status]);
		}
	}
	


	public function scanguru()
{
    $json = $this->request->getJSON();
    log_message('error', 'Data JSON diterima: ' . json_encode($json)); 
    $qrData = $json->qr_data ?? '';

    if (!$qrData) {
        return $this->response->setJSON(['success' => false, 'message' => 'QR Code tidak valid']);
    }

    $joyce = new M_guru;
    $nana = new M_absenguru;

    $tanggal = date('Y-m-d');
    $jam_absen = date('H:i:s');
    $jam_sekarang = strtotime($jam_absen);
    log_message('error', 'Sekarang jam: ' . $jam_absen);
    log_message('error', 'Tanggal yang digunakan: ' . $tanggal); 

    // 🛑 Validasi Hari Libur (Minggu/libur nasional)
    // $hari = date('w'); // 0 = Minggu, 6 = Sabtu
    // if ($hari == 0) {
    //     return $this->response->setJSON(['success' => false, 'message' => 'Hari ini adalah hari libur.']);
    // }

    // Cek hari libur dari tabel
    // $libur = $joyce->table('libur')
    //     ->where('tanggal', $tanggal)
    //     ->get()
    //     ->getRow();
    // if ($libur) {
    //     return $this->response->setJSON(['success' => false, 'message' => 'Hari ini libur: ' . $libur->keterangan . '. Tidak perlu absen.']);
    // }

    // Cari guru berdasarkan NIK
    $guru = $joyce->table('guru')
                ->where('nik', $qrData)
                ->get()
                ->getRow();

    if (!$guru) {
        return $this->response->setJSON(['success' => false, 'message' => 'Guru tidak ditemukan']);
    }

    // Cek apakah guru sudah absen hari ini
    $existing = $nana->where('id_guru', $guru->id_guru)
        ->where('tanggal', $tanggal)
        ->first();

    if ($existing) {
        // Sudah absen → proses absen pulang
        if ($jam_sekarang >= strtotime('18:00:00') && $jam_sekarang <= strtotime('21:00:00')) {
            $updateData = [
                'jam_pulang' => $jam_absen,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session()->get('id')
            ];
            log_message('error', 'Isi updateData: ' . json_encode($updateData));
            $nana->update($existing['id_absenguru'], $updateData);

            helper('log');
            log_activity(session()->get('id'), 'Absensi pulang ID Guru: ' . $guru->id_guru);
            return $this->response->setJSON(['success' => true, 'message' => 'Absensi pulang berhasil!']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Absen pulang hanya boleh antara 18:00 - 21:00']);
        }
    } else {
        // Belum absen → proses absen masuk
        if ($jam_sekarang >= strtotime('07:00:00') && $jam_sekarang <= strtotime('23:00:00')) {
            $status = 'Hadir';
        } elseif ($jam_sekarang >= strtotime('16:00:00') && $jam_sekarang <= strtotime('18:00:00')) {
            $status = 'Terlambat';
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Absen masuk hanya boleh antara 07:00 - 18:00']);
        }

        // Simpan sebagai jam_masuk
        $data = [
            'id_guru' => $guru->id_guru,
            'tanggal' => $tanggal,
            'jam_masuk' => $jam_absen,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => session()->get('id')
        ];
        $nana->save($data);

        helper('log');
        log_activity(session()->get('id'), 'Absensi masuk ID Guru: ' . $guru->id_guru . ' dengan status ' . $status);
        return $this->response->setJSON(['success' => true, 'message' => 'Absensi masuk berhasil dengan status: ' . $status]);
    }
}

	protected function logActivity($activity) 
   {
        $joyce = new M_log;

        $id_user = session()->get('id_user');
        if (!$id_user) return;

        $ip_address = $this->request->getIPAddress();

        $joyce->saveLog($id_user, $activity, $ip_address);
    }

	public function activity()
	{
		if (session()->get('level')=='1' || session()->get('level')=='4'){ 
			$joyce= new M_absen;
			$wendy['anjas']=$joyce->activity();
			$apel['mey']=$joyce->settings();

			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('activity',$wendy);
			echo view('footer');
			helper('log');
			log_activity(session()->get('id'), 'Mengakses halaman data Log Activity');
		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}
    public function kartusiswa()
    {
        // Load model
        $model = new M_siswa();
        $id_user = session()->get('id'); // ID user yang login
        $siswa = $model->kartu($id_user);

        if (!$siswa) {
            return "Data siswa tidak ditemukan!";
        }

        $width = 800;
		$height = 400;
		$image = imagecreatetruecolor($width, $height);
		
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		
		imagefilledrectangle($image, 0, 0, $width, $height, $white);
    
    // Tambah logo di atas
		$logoPath = FCPATH . 'img/logo (2).png'; // Pastikan path benar
		if (file_exists($logoPath)) {
			$logo = imagecreatefrompng($logoPath);
			
			// Ambil ukuran asli logo
			$logoOriginalWidth = imagesx($logo);
			$logoOriginalHeight = imagesy($logo);
			
			// Tentukan ukuran baru logo (misalnya, lebar 120px, tinggi otomatis mengikuti proporsi)
			$logoNewWidth = 230;
			$logoNewHeight = ($logoOriginalHeight / $logoOriginalWidth) * $logoNewWidth;
			
			// Tempel logo di posisi (20,20)
			imagecopyresampled($image, $logo, 20, 20, 0, 0, $logoNewWidth, $logoNewHeight, $logoOriginalWidth, $logoOriginalHeight);
		}
		// Tambah teks "KARTU PELAJAR SISWA" di samping logo
			$font = FCPATH . 'assets/fonts/Lora/static/Lora-Bold.ttf'; // Pastikan font tersedia
			$judul = "KARTU PELAJAR SISWA";
			$fontSize = 26; // Ukuran font
			$xText = 370; // Posisi X (supaya di samping logo)
			$yText = 90; // Posisi Y (tinggi sejajar logo)
			imagettftext($image, $fontSize, 0, $xText, $yText, $black, $font, $judul);

	
		// Tambah foto siswa
		$fotoPath = FCPATH . 'img/' . $siswa->foto;
		if (file_exists($fotoPath)) {
			$foto = imagecreatefromjpeg($fotoPath);
			imagecopyresized($image, $foto, 50, 140, 0, 0, 150, 150, imagesx($foto), imagesy($foto));
		}
		
		// Tambah QR Code
		$qrPath = FCPATH . 'img/' . $siswa->code;
		if (file_exists($qrPath)) {
			$qr = imagecreatefrompng($qrPath);
			imagecopyresized($image, $qr, 600, 140, 0, 0, 150, 150, imagesx($qr), imagesy($qr));
		}
		
		// Tambah teks
		$font = FCPATH . 'assets/fonts/Kanit/Kanit-Regular.ttf'; // Pastikan font tersedia
		imagettftext($image, 20, 0, 220, 170, $black, $font, "Nama: " . $siswa->nama_siswa);
		imagettftext($image, 20, 0, 220, 210, $black, $font, "NIS: " . $siswa->nis);
		imagettftext($image, 20, 0, 220, 250, $black, $font, "Jenis Kelamin: " . $siswa->jenis_kelamin);
		imagettftext($image, 20, 0, 220, 290, $black, $font, "Alamat: " . $siswa->alamat);
		
		// Simpan sebagai gambar
		$filePath = FCPATH . 'img/kartu_' . $siswa->nis . '.png';
		imagepng($image, $filePath);
		
		imagedestroy($image);
		
		return redirect()->to(base_url('img/kartu_' . $siswa->nis . '.png'));
	}
	public function kartuguru()
	{
		// Load model
		$model = new M_gurukartu();
		$id_user = session()->get('id'); // ID user yang login
		$guru = $model->kartu($id_user);
		// dd($id_user); // Debug ID user yang login

		if (!$guru) {
			return "Data guru tidak ditemukan!";
		}

		$width = 800;
		$height = 400;
		$image = imagecreatetruecolor($width, $height);
		
		$white = imagecolorallocate($image, 255, 255, 255);
		$black = imagecolorallocate($image, 0, 0, 0);
		
		imagefilledrectangle($image, 0, 0, $width, $height, $white);

		// Tambah logo di atas
		$logoPath = FCPATH . 'img/logo (2).png'; // Pastikan path benar
		if (file_exists($logoPath)) {
			$logo = imagecreatefrompng($logoPath);
			$logoOriginalWidth = imagesx($logo);
			$logoOriginalHeight = imagesy($logo);
			$logoNewWidth = 230;
			$logoNewHeight = ($logoOriginalHeight / $logoOriginalWidth) * $logoNewWidth;
			imagecopyresampled($image, $logo, 20, 20, 0, 0, $logoNewWidth, $logoNewHeight, $logoOriginalWidth, $logoOriginalHeight);
		}

		// Tambah teks "KARTU PENGAJAR"
		$font = FCPATH . 'assets/fonts/Lora/static/Lora-Bold.ttf';
		$judul = "KARTU PENGAJAR";
		$fontSize = 26;
		$xText = 370;
		$yText = 90;
		imagettftext($image, $fontSize, 0, $xText, $yText, $black, $font, $judul);

		// Tambah foto guru
		$fotoPath = FCPATH . 'img/' . $guru->foto;
		if (file_exists($fotoPath)) {
			$foto = imagecreatefromjpeg($fotoPath);
			imagecopyresized($image, $foto, 50, 140, 0, 0, 150, 150, imagesx($foto), imagesy($foto));
		}

		// Tambah QR Code
		$qrPath = FCPATH . 'img/' . $guru->code;
		if (file_exists($qrPath)) {
			$qr = imagecreatefrompng($qrPath);
			imagecopyresized($image, $qr, 600, 140, 0, 0, 150, 150, imagesx($qr), imagesy($qr));
		}

		// Tambah teks identitas guru
		$font = FCPATH . 'assets/fonts/Kanit/Kanit-Regular.ttf';
		imagettftext($image, 20, 0, 220, 170, $black, $font, "Nama: " . $guru->nama_guru);
		imagettftext($image, 20, 0, 220, 210, $black, $font, "NIK: " . $guru->nik);
		imagettftext($image, 20, 0, 220, 250, $black, $font, "Jenis Kelamin: " . $guru->jenis_kelamin);
		imagettftext($image, 20, 0, 220, 290, $black, $font, "Alamat: " . $guru->alamat);

		// Simpan sebagai gambar
		$filePath = FCPATH . 'img/kartu_guru_' . $guru->nik . '.png';
		imagepng($image, $filePath);

		imagedestroy($image);

		return redirect()->to(base_url('img/kartu_guru_' . $guru->nik . '.png'));
	}
	public function web()
	{
		if (session()->get('level')=='4'){  
			$joyce= new M_absen;
			$wendy['mey']=$joyce->settings();
			if (session()->get('level')==2) {
				$where=array('guru.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
			}else if (session()->get('level')==1 || session()->get('level')=='4') {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}else if (session()->get('level')==3) {
				$where=array('siswa.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
			}


			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman setting web');
			$data = array_merge($wendy, $hee);
			echo view('header',$data);
			echo view('web',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('absen/error');
		}else{
			return redirect()->to('absen/login');
		}
	}
	public function editweb ($id)
	{

		$joyce= new M_absen;
		$wece= array('id' =>$id);
		$wendy['mey']=$joyce->getWhere('setting',$wece);
		$where=('id');
		$apel['mey']=$joyce->settings();

	
		if (session()->get('level')==2) {
			$where=array('guru.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'guru', 'user.id_user=guru.id_user',$where);
		}else if (session()->get('level')==1 || session()->get('level')=='4') {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}else if (session()->get('level')==3) {
			$where=array('siswa.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'siswa', 'user.id_user=siswa.id_user',$where);
		}


			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('editweb',$wendy);
		echo view('footer');
		
	}
	public function saveweb (){
		$joyce = new M_web();    
        $foto = $this->request->getPost('fotoweb');
    
        $file = $this->request->getFile('fotoweb');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('assets/img', $newName);
    
            if (!empty($produk['foto']) && file_exists('assets/img/' . $produk['foto'])) {
                unlink('assets/img/' . $produk['foto']);
            }
        } else {
            $newName = $produk['foto'];
        }
    
        $data = [
            'nama' => $this->request->getPost('namaweb'),
            'foto' => $newName
        ];
    
        $joyce->update('setting', $data);
    
        session()->setFlashdata('success', 'Setting web berhasil diperbarui!');
    
        return redirect()->to(base_url('absen/web'));
	}
	public function lupa_password()
	{
		return view('forgot_password');
	}

	public function kirim_reset_password()
	{
		$username = $this->request->getPost('username');
		$userModel = new \App\Models\UserModel();
		$user = $userModel->where('username', $username)->first();
	
		if (!$user) {
			return redirect()->back()->with('error', 'Username tidak ditemukan.');
		}
	
		$email = $user['email'];
		$token = bin2hex(random_bytes(16));
	
		$userModel->update($user['id'], ['reset_token' => $token]);
	
		$maskedEmail = $this->maskEmail($email);
		session()->setFlashdata('masked_email', $maskedEmail);
	
		// ✅ Panggil fungsi kirim email
		$this->kirimEmailReset($email, $token);
	
		return view('forgot_confirmation');
	}
	

	public function reset_password($token)
	{
		$userModel = new \App\Models\UserModel();
		$user = $userModel->where('reset_token', $token)->first();
	
		if (!$user) {
			return redirect()->to('/absen/login')->with('error', 'Token tidak valid');
		}
	
		return view('reset_password', ['token' => $token]);
	}
	
	public function simpan_password_baru()
	{
		$token = $this->request->getPost('token');
		$password = $this->request->getPost('password');
	
		$userModel = new \App\Models\UserModel();
		$user = $userModel->where('reset_token', $token)->first();
	
		if (!$user) {
			return redirect()->to('/absen/login')->with('error', 'Token tidak valid');
		}
	
		$userModel->update($user['id_user'], [
			'password' => $password,
			'reset_token' => null
		]);
	
		return redirect()->to('/absen/login')->with('success', 'Password berhasil diubah');
	}
	
	private function maskEmail($email)
	{
		$at = strpos($email, '@');
		return substr($email, 0, 1) . '*****' . substr($email, $at - 1);
	}
	
	private function kirimEmailReset($email, $token)
	{
		$emailService = \Config\Services::email();
	
		$emailService->setTo($email);
		$emailService->setReplyTo('yippiebluu@gmail.com', 'Aplikasi Absensi');
		$emailService->setSubject('Permintaan Reset Password - Aplikasi Absensi');
	
		$resetLink = base_url('absen/reset_password/' . $token);
	
		$message = "
			<h3>Permintaan Reset Password</h3>
			<p>Kami menerima permintaan untuk mereset password akun Anda.</p>
			<p>Silakan klik link di bawah ini untuk mengatur ulang password Anda:</p>
			<p><a href='{$resetLink}'>{$resetLink}</a></p>
			<br>
			<p>Abaikan email ini jika Anda tidak merasa melakukan permintaan ini.</p>
		";
	
		$emailService->setMessage($message);
		$emailService->setMailType('html'); // karena isi email HTML
	
		if ($emailService->send()) {
			return true;
		} else {
			// untuk debugging
			echo $emailService->printDebugger(['headers']);
			return false;
		}
	}
	
	
	public function testEmail()
{
    $email = 'emailtujuan@gmail.com'; // ganti dgn email tujuan
    $token = 'contohtoken123';

    $emailService = \Config\Services::email();

    $emailService->setFrom('yippiebluu@gmail.com', 'Aplikasi Absensi');
    $emailService->setTo($email);
    $emailService->setSubject('Tes Email');
    $emailService->setMessage('Ini adalah email tes dari CodeIgniter');
    $emailService->setMailType('html');

    if ($emailService->send()) {
        echo '✅ Email berhasil dikirim!';
    } else {
        echo '❌ Gagal kirim email!<br><br>';
        print_r($emailService->printDebugger(['headers', 'subject', 'body']));
    }
}


}
