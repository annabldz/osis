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
use App\Models\M_dokumentasi;
use App\Models\M_LPJ;
use App\Models\M_log;
use App\Models\M_softdelete;
use App\Models\KeuanganModel;
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
use App\Models\KegiatanModel;
use App\Models\ProkerModel;
use App\Models\DokumentasiModel;

class Home extends BaseController
{
    public function login()
    {
		$angka1 = rand(1, 10);
		$angka2 = rand(1, 10);
		$soal = "$angka1 + $angka2";
		session()->set('captcha_jawaban', $angka1 + $angka2);

		echo view('login', ['soal_captcha' => $soal]);

    }
	public function logout(){
		helper('log'); 
		log_activity(session()->get('id'), 'User logout');

		session()->destroy();
		return redirect()->to('home/login');
	}
	public function aksi_login()
	{
		helper('log');
		$isOnline = $this->request->getPost('is_online');
	
		if ($isOnline == "1") {
			// ✅ PAKAI GOOGLE CAPTCHA
			$recaptcha_secret = "6LfA0g0rAAAAAGRnbgLQuPorL2GyKdtE_qA4nPOZ"; // Replace with your actual secret key
			$recaptcha_response = $_POST['g-recaptcha-response'];
	
		// Verify with Google
			$verify_url = "https://www.google.com/recaptcha/api/siteverify";
			$response = file_get_contents($verify_url . "?secret=" . $recaptcha_secret . "&response=" . $recaptcha_response);
			$response_keys = json_decode($response, true);
		
			if (!$response_keys["success"]) {
				die("reCAPTCHA verification failed. Please try again.");
			}
		} else {
			// ❌ PAKAI MATH CAPTCHA LOKAL
			$jawabanUser = $this->request->getPost('captcha_jawaban');
			$jawabanBenar = session()->get('captcha_jawaban');
			if ((int)$jawabanUser !== (int)$jawabanBenar) {
				return redirect()->back()->with('error', 'Jawaban captcha salah!');
			}
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
		if (empty($a) || empty($b)) {
			return redirect()->back()->with('error', 'Username dan password wajib diisi!');
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
	
		return redirect()->to('home/dashboard');
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
			// $where=array('anggota.id_user' => session()->get('id'));
			// $wendy['iyah'] = $joyce->jwhere('user', 'anggota', 'anggota.id_user = user.id_user', $where);

			$apel['mey']=$joyce->settings();

			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
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
		if (session()->get('level')=='1'|| session()->get('level')=='2' || session()->get('level')=='3' || session()->get('level')=='4' || session()->get('level')=='5'|| session()->get('level')=='6' || session()->get('level')=='7' || session()->get('level')=='8' || session()->get('level')=='9'){  
			$joyce= new M_absen;
			$apel['mey']=$joyce->settings();
			$wendy['anggota']=$joyce->anggota();
			// $wendy['guru']=$joyce->guru();
			$where=('id_user');
			$wendy['id_user']=$joyce->tampil('user', $where);
			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
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
		if (session()->get('level')=='8' || session()->get('level')=='9'){  
			$this->logActivity("Mengakses Tabel User");
			$joyce= new M_absen;
			$rela= new UserModel;
			$anna= new M_softdelete;
			$apel['mey']=$joyce->settings();

			$where=('id_user');
			$wendy = [
				'title' => 'Data User',
				'anjas' => $joyce->tampiluser('user', $where),
				'deleted_user' => $anna->getDeletedUser(),
				'showWelcome' => false 
			];
			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}
			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman data User');
			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('user',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}

	public function anggota()
	{
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7  || session()->get('level')== 8  || session()->get('level')== 9 )  {
			$joyce= new M_absen;
		$anna= new M_deleteguru;
		$apel['mey']=$joyce->settings();

			  $where=('id_anggota');
			  $wendy = [
				  'title' => 'Data Anggota',
				  'anjas' => $joyce->anggota(),
				  'deleted_user' => $anna->getDeletedGuru(),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}


		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('anggota',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Anggota');
		
	  }else if(session()->get('level')>0){
		return redirect()->to('home/error');
	  }else{
		return redirect()->to('home/login');
	  }
	}
		public function editanggota ($id)
	{

		$joyce= new M_absen;
		$apel['mey']=$joyce->settings();

		$wece= array('id_anggota' =>$id);
		$wendy['anjas']=$joyce->getWhere('anggota',$wece);
		$where=('id_anggota');

			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}
			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('editanggota',$wendy);
		echo view('footer');
		
	}
	public function saveanggota ()
	{
		$session = session();
		$userID = $session->get('id'); 
		$a = $this->request->getPost('nama'); // Nama guru
		$b = $this->request->getPost('jabatan');  // NIK guru
		$c = $this->request->getPost('tahun');   // ID guru
		$d = $this->request->getPost('id'); // Foto (kalau perlu)
		$e = $this->request->getPost('user'); // ID user di tabel `user`
	    $createdAt    = date('Y-m-d H:i:s');

		$joyce = new M_absen;
	
		// Update data di tabel guru
		$whereGuru = ['id_anggota' => $d];
		$dataGuru = [
			"nama_anggota"  => $a,
			"jabatan"        => $b,
			"tahun_ajaran"        => $c,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];
		$joyce->edit('anggota', $dataGuru, $whereGuru);
	
		// Simpan log activity
		helper('log');
		log_activity($userID, 'Mengedit data guru ' . $a . ' dengan ID: ' . $d);
	
		return redirect()->to('home/anggota');
	}

	public function hapusanggota($id_anggota)
    {
        $joyce = new M_deleteguru();
        $result = $joyce->softDelete($id_anggota);
		$userID = session()->get('id');
		helper('log');
		log_activity($userID, "Menghapus data guru dengan ID: " . $id_anggota);
        if ($result) {

            return redirect()->to('home/anggota')->with('success', 'User berhasil dihapus (soft delete)');
        } else {
            return redirect()->to('home/anggota')->with('error', 'User tidak ditemukan');
        }
    }

    public function restoreanggota($id_anggota)
    {
        $joyce = new M_deleteguru();
        $result = $joyce->restore($id_anggota);
    $userID = session()->get('id');
    helper('log');
    log_activity($userID, "Merestore data guru dengan ID: " . $id_anggota);
        if ($result) {

            return redirect()->to('home/anggota')->with('success', 'User berhasil direstore');
        } else {
            return redirect()->to('home/anggota')->with('error', 'User tidak ditemukan');
        }
    }
	
	public function inputanggota ()
	{
		$joyce= new M_absen;
		$where=('id_anggota');
		$wendy['anggota']=$joyce->tampil('anggota',$where);
		$where=('id_user');
		$wendy['user']=$joyce->tampil('user',$where);
		$wendy['iyah']=$joyce->join('anggota','user','anggota.id_user=user.id_user');
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('inputanggota', $wendy);
		echo view('footer');

	}
	public function saveianggota()
{
    $session = session();
    $userID = $session->get('id'); // ID user yang login
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
    $file         = $this->request->getFile('file');
    $nama         = $this->request->getPost('nama');
    $namaUser     = $this->request->getPost('namauser');
    $jabatan      = $this->request->getPost('jabatan');
    $tahunAjaran  = $this->request->getPost('tahun_ajaran');
    $username     = $this->request->getPost('username');
    $email        = $this->request->getPost('email');
	$e = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT); // hash password
    $level        = $this->request->getPost('level');
    $createdAt    = date('Y-m-d H:i:s');

    // Upload foto
    $newFileName = '';
    if ($file->isValid() && !$file->hasMoved()) {
        $newFileName = time() . '_' . $file->getClientName();
        $file->move('img/', $newFileName);
    }

    $model = new M_absen();
	if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $e)) {
		return redirect()->back()->with('error', 'Password tidak memenuhi kriteria keamanan!');
	}
    // Simpan ke tabel user
    $dataUser = [
        'foto'       => $newFileName,
        'username'   => $username,
        'password'   => $password,
        'level'      => $level,
		'email'      => $email,
        'nama_user'  => $namaUser,
        'created_at' => $createdAt,
        'created_by' => $userID,
    ];
    $model->input('user', $dataUser);
    $id_user = $model->insertID(); // Ambil ID user yg baru

    // Simpan ke tabel anggota
    $dataAnggota = [
        'id_user'      => $id_user,
        'nama_anggota' => $nama,
        'jabatan'      => $jabatan,
        'tahun_ajaran' => $tahunAjaran,
        'created_at'   => $createdAt,
        'created_by'   => $userID,
    ];
    $model->input('anggota', $dataAnggota);

    // Simpan log aktivitas
    helper('log');
    log_activity($userID, "Menambahkan anggota OSIS: " . $nama . " dengan ID user: " . $id_user);

    return redirect()->to('/home/anggota'); // Ganti sesuai route kamu
}


	public function proker()
	{
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7  || session()->get('level')== 8  || session()->get('level')== 9 )  {
			$joyce= new M_absen;
		$anna= new M_deletesiswa;
		$apel['mey']=$joyce->settings();

			  $where=('id_proker');
			  $wendy = [
				  'title' => 'Data Proker',
				  'anjas' => $joyce->proker(),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}

		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('proker',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Proker');
	  }else if(session()->get('level')>0){
		return redirect()->to('home/error');
	  }else{
		return redirect()->to('home/login');
	  }
	}
		public function editproker ($id)
	{

		$joyce= new M_absen;
		$wece= array('id_proker' =>$id);
		$wendy['anjas']=$joyce->getWhere('proker',$wece);
		$where=('id_proker');
		
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('editproker',$wendy);
		echo view('footer');
		
	}
	public function saveproker()
	{
		$a = $this->request->getPost('nama');
		$b = $this->request->getPost('deskripsi');
		$c = $this->request->getPost('tanggal');
		$f = $this->request->getPost('status');
		$d = $this->request->getPost('id');
		$userID = session()->get('id');

		$joyce = new M_absen;
		$wece = ['id_proker' => $d];

		$data = [
			"judul_proker" => $a,
			"deskripsi_proker" => $b,
			"tanggal_pelaksanaan" => $c, 
			"status" => $f,
			"updated_by" => $userID, // Tambahkan updated_by
			"updated_at" => date('Y-m-d H:i:s') // Tambahkan updated_at
		];

		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "Mengedit data proker: " . $a . " dengan ID Proker: " . $d);

		$joyce->edit('proker', $data, $wece);
		return redirect()->to('home/proker');
	}

	public function inputproker ()
	{
		$joyce= new M_absen;
		$where=('id_proker');
		$wendy['proker']=$joyce->tampil('proker',$where);
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('inputproker', $wendy);
		echo view('footer');

	}
	public function saveiproker()
	{
		$session = session();
		$userID = $session->get('id'); // ID user yang login

		$nama         = $this->request->getPost('nama');
		$deskripsi         = $this->request->getPost('deskripsi');
		$tanggal     = $this->request->getPost('tanggal');
		$status      = $this->request->getPost('status');
		$createdAt    = date('Y-m-d H:i:s');

		// Upload foto


		$model = new M_absen();

		// Simpan ke tabel user
		$dataUser = [
			'judul_proker'   => $nama,
			'deskripsi_proker'   => $deskripsi,
			'tanggal_pelaksanaan'      => $tanggal,
			'status'      => $status,
			'created_at' => $createdAt,
			'created_by' => $userID,
		];
		$model->input('proker', $dataUser);
		$id_user = $model->insertID(); // Ambil ID user yg baru

		
		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "User " . $id_user ."Menambahkan Proker Bernama: " . $nama);

		return redirect()->to('/home/proker'); // Ganti sesuai route kamu
	}

	public function kegiatan()
	{
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7  || session()->get('level')== 8  || session()->get('level')== 9 )  {
			$joyce= new M_absen;
			$nana = new M_LPJ;

				$apel['mey']=$joyce->settings();

			  	$where=('id_kegiatan');
			  	$wendy = [
				  'title' => 'Data Kegiatan',
				  'anjas' => $joyce->kegiatan(),
				  'lpj' => $nana->getByIdKegiatan($id_kegiatan),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}

		$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('kegiatan',$wendy);
			echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Kegiatan');
	  }else if(session()->get('level')>0){
		return redirect()->to('home/error');
	  }else{
		return redirect()->to('home/login');
	  }
	}
	public function editkegiatan ($id)
	{

		$joyce= new M_absen;
		$wece= array('id_kegiatan' =>$id);
		$wendy['anjas']=$joyce->getWhere('kegiatan',$wece);
		$where=('id_kegiatan');
		
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('editkegiatan',$wendy);
		echo view('footer');
		
	}
	public function savekegiatan()
	{
		$a = $this->request->getPost('nama');
		$b = $this->request->getPost('deskripsi');
		$c = $this->request->getPost('tanggal');
		$f = $this->request->getPost('status');
		$d = $this->request->getPost('id');
		$userID = session()->get('id');

		$joyce = new M_absen;
		$wece = ['id_proker' => $d];

		$data = [
			"judul_proker" => $a,
			"deskripsi_proker" => $b,
			"tanggal_pelaksanaan" => $c, 
			"status" => $f,
			"updated_by" => $userID, 
			"updated_at" => date('Y-m-d H:i:s') 
		];

		helper('log');
		log_activity($userID, "Mengedit data proker: " . $a . " dengan ID Proker: " . $d);

		$joyce->edit('proker', $data, $wece);
		return redirect()->to('home/proker');
	}

	public function inputkegiatan ()
	{
		$joyce= new M_absen;
		$where=('id_kegiatan');
		$wendy['anjas']=$joyce->tampil('kegiatan',$where);
		$where=('id_proker');
		$wendy['proker']=$joyce->tampil('proker',$where);
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('inputkegiatan', $wendy);
		echo view('footer');

	}
	public function saveikegiatan()
	{
		$model = new M_absen();
		$session = session();
		$userID = $session->get('id'); 
		$proposal = $this->request->getFile('proposal_file');
		if (!$proposal->isValid() || $proposal->getClientMimeType() !== 'application/pdf') {
			return redirect()->back()->with('error', 'File proposal harus berupa PDF.');
		}
		$newName = $proposal->getRandomName();
    	$proposal->move('uploads/proposal', $newName);

		 $data = [
        'id_proker'         => $this->request->getPost('proker'),
        'judul_kegiatan'    => $this->request->getPost('nama'),
        'tanggal_kegiatan'  => $this->request->getPost('tanggal'),
        'waktu'             => $this->request->getPost('waktu'),
        'lokasi'            => $this->request->getPost('lokasi'),
        'proposal_file'     => $newName,
        'status_kegiatan'            => 'Menunggu persetujuan',
		"created_by" => $userID,
		"created_at" => date('Y-m-d H:i:s')
    ];
		
		$model->input('kegiatan', $data);
		$id_user = $model->insertID(); 

		
		helper('log');
		log_activity($userID, "User " . $id_user ."Menambahkan Kegiatan Bernama: " . $nama);

		return redirect()->to('/home/kegiatan'); // Ganti sesuai route kamu
	}
	public function getKalender()
{
    $model = new \App\Models\KegiatanModel();
    $data = $model->findAll();

    $events = [];

    foreach ($data as $kegiatan) {
        $events[] = [
            'title' => $kegiatan['judul_kegiatan'],
            'start' => $kegiatan['tanggal_kegiatan'],
            'url'   => base_url('/home/detail/' . $kegiatan['id_kegiatan']),
        ];
    }

    return $this->response->setJSON($events);
}

	public function setujui_kegiatan($id)
	{
		$model = new \App\Models\KegiatanModel();
		$model->update($id, [
			'status_kegiatan' => 'Berjalan',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => session()->get('id') // atau ID user, sesuai aplikasi kamu
		]);
		helper('log');
		log_activity($userID, "Menyetujui Proposal dengan ID: " . $id);
		return redirect()->to('/home/kegiatan')->with('success', 'Proposal telah disetujui dan status diubah jadi Berjalan.');
	}
	public function tolakproposal($id)
	{
		$prokerModel = new ProkerModel(); 

		$model = new KegiatanModel();
		$session = session();
		$userID = $session->get('id');

		$model->update($id, [
			'status_kegiatan' => 'Ditolak',
			'updated_by' => $userID,
			'updated_at' => date('Y-m-d H:i:s')
		]);
		$prokerModel->update($id, [
			'status' => 'Tidak Terlaksana',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $userID,
		]);
		helper('log');
		log_activity($userID, "Menolak proposal kegiatan ID: $id");

		return redirect()->back()->with('success', 'Proposal berhasil ditolak.');
	}
	public function proses_kegiatan($id)
	{
		$kegiatanModel = new \App\Models\KegiatanModel();
		$prokerModel   = new \App\Models\ProkerModel();
		$session       = session();
		$userID        = $session->get('id');
	
		$aksi = $this->request->getPost('aksi');
		$komentar = $this->request->getPost('komentar');
	
		$kegiatan = $kegiatanModel->find($id);
		if (!$kegiatan) {
			return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
		}
	
		// Simpan komentar dan aksi
		$updateKegiatan = [
			'komentar'     => $komentar,
			'updated_at'   => date('Y-m-d H:i:s'),
			'updated_by'   => $userID
		];
		$updateProker = [
			'komentar'     => $komentar,
			'updated_at'   => date('Y-m-d H:i:s'),
			'updated_by'   => $userID
		];
	
		if ($aksi === 'setujui') {
			$updateKegiatan['status_kegiatan'] = 'Berjalan';
			$pesan = 'Proposal telah disetujui dan status diubah jadi Berjalan.';
		} elseif ($aksi === 'tolak') {
			$updateKegiatan['status_kegiatan'] = 'Ditolak';
			$updateProker['status'] = 'Tidak Terlaksana';
			$pesan = 'Proposal telah ditolak.';
		} elseif ($aksi === 'selesai') {
			$updateKegiatan['status_kegiatan'] = 'Selesai';
			$updateProker['status'] = 'Terlaksana';
			$pesan = 'Kegiatan diselesaikan dan status proker diubah menjadi Terlaksana.';
		} else {
			return redirect()->back()->with('error', 'Aksi tidak valid.');
		}
	
		$kegiatanModel->update($id, $updateKegiatan);
		$prokerModel->update($kegiatan['id_proker'], $updateProker);
	
		helper('log');
		log_activity($userID, "Melakukan aksi [$aksi] pada kegiatan ID: $id");
	
		return redirect()->to('/home/kegiatan')->with('success', $pesan);
	}
	
	public function selesaikankegiatan($id)
	{
		$kegiatanModel = new \App\Models\KegiatanModel();
		$prokerModel   = new \App\Models\ProkerModel();
	
		// Ambil data kegiatan terlebih dahulu, untuk mendapatkan id_proker
		$kegiatan = $kegiatanModel->find($id);
	
		if (!$kegiatan) {
			return redirect()->back()->with('error', 'Kegiatan tidak ditemukan.');
		}
	
		$userID = session()->get('id');
	
		// Update status kegiatan jadi "Selesai"
		$kegiatanModel->update($id, [
			'status_kegiatan' => 'Selesai',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $userID,
		]);
	
		// Update status proker jadi "Terlaksana"
		$prokerModel->update($kegiatan['id_proker'], [
			'status' => 'Terlaksana',
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => $userID,
		]);
		
	
		// Log aktivitas
		helper('log');
		log_activity($userID, "Menyelesaikan kegiatan ID: $id dan mengubah status proker ID: {$kegiatan['id_proker']}");
	
		return redirect()->to('/home/kegiatan')->with('success', 'Kegiatan diselesaikan dan status Proker diubah menjadi Terlaksana.');
	}
	
	public function proses_lpj($id_kegiatan)
	{
		$lpjModel      = new \App\Models\M_LPJ();
		$kegiatanModel = new \App\Models\KegiatanModel();
		$prokerModel   = new \App\Models\ProkerModel();
		$session       = session();
		$userID        = $session->get('id');

	
		$tipe       = $this->request->getPost('tipe');
		$jumlah     = $this->request->getPost('jumlah');
		$sumber     = $this->request->getPost('sumber');
		$penggunaan = $this->request->getPost('penggunaan');
		$files = $this->request->getFiles()['bukti'];
		$tanggal = $this->request->getPost('tanggal');
	
		if (empty($tipe) || !is_array($tipe) || count($tipe) < 1) {
			return redirect()->back()->with('error', 'Minimal 1 data LPJ harus diisi.');
		}
	
	$dataBatch = [];
	
	for ($i = 0; $i < count($tipe); $i++) {
		$namaFile = null;

		// Upload jika ada file
		if (isset($files[$i]) && $files[$i]->isValid() && !$files[$i]->hasMoved()) {
			$namaFile = $files[$i]->getRandomName();
			$files[$i]->move('img/', $namaFile);
		}
		$dataBatch[] = [
			'id_kegiatan' => $id_kegiatan,
			'tipe'        => $tipe[$i],
			'jumlah'      => $jumlahBersih = str_replace('.', '', $jumlah[$i]), 
			'sumber'      => ($tipe[$i] === 'Pemasukan') ? $sumber[$i] : null,
			'penggunaan'  => ($tipe[$i] === 'Pengeluaran') ? $penggunaan[$i] : null,
			'bukti'       => $namaFile,
        	'tanggal'     => $tanggal[$i],
		];	
	}
	$result = $lpjModel->insertBatch($dataBatch);

	// echo '<pre>';
	// print_r($dataBatch);
	// echo '</pre>';
	// exit;
	
	
		$kegiatanModel->update($id_kegiatan, [
			'status_kegiatan' => 'Selesai',
			'updated_at'      => date('Y-m-d H:i:s'),
			'updated_by'      => $userID,
		]);
	
		$kegiatan = $kegiatanModel->find($id_kegiatan);
	
		$prokerModel->update($kegiatan['id_proker'], [
			'status'      => 'Terlaksana',
			'updated_at'  => date('Y-m-d H:i:s'),
			'updated_by'  => $userID,
		]);
	
		helper('log');
		log_activity($userID, "Menginput LPJ untuk kegiatan ID: $id");
	
		return redirect()->to('/home/kegiatan')->with('success', 'LPJ berhasil disimpan dan status kegiatan diperbarui.');
	}
	public function perKegiatan($id_kegiatan)
	{
		$model = new M_LPJ();
		$joyce = new M_absen();
		$data['lpj'] = $model->getByIdKegiatan($id_kegiatan);
		$data['id_kegiatan'] = $id_kegiatan;
		$apel['mey']=$joyce->settings();
		echo view('header', $apel);
		echo view('lpjactivity', $data);
	}
	public function proposal()
	{
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7  || session()->get('level')== 8  || session()->get('level')== 9 )  {
			$joyce= new M_absen;
		$anna= new M_deletesiswa;
		$lala= new KegiatanModel;

		$apel['mey']=$joyce->settings();

			  $wendy = [
				  'title' => 'Data Kegiatan',
				  'anjas' => $lala->proposal(),
				  'showWelcome' => false 
			  ];
			  if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}

		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('proposal',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Proker');
	  }else if(session()->get('level')>0){
		return redirect()->to('home/error');
	  }else{
		return redirect()->to('home/login');
	  }
	}
	public function dokumentasi()
	{
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7  || session()->get('level')== 8  || session()->get('level')== 9 )  {
			$joyce= new M_absen;
		$lala= new KegiatanModel;

		$apel['mey']=$joyce->settings();

				$wendy = [
					'mading' => $joyce->getDokumentasiByKategori('Mading'),
					'acara' => $joyce->getDokumentasiByKategori('Acara Sekolah'),
					'keagamaan' => $joyce->getDokumentasiByKategori('Keagamaan'),
					'title' => 'Dokumentasi Kegiatan'
				];
			  if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}

		$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('dokumentasi',$wendy);
		echo view('footer');
		helper('log');
		  log_activity(session()->get('id'), 'Mengakses halaman data Proker');
	  }else if(session()->get('level')>0){
		return redirect()->to('home/error');
	  }else{
		return redirect()->to('home/login');
	  }
	}
	public function inputdokumentasi ()
	{
		$joyce= new M_absen;
		$where=('id_dokumentasi');
		$wendy['anjas']=$joyce->tampil('dokumentasi',$where);
		$apel['mey']=$joyce->settings();

		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
		}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
		echo view('inputdokumentasi', $wendy);
		echo view('footer');

	}
	public function savedokumentasi()
	{
		$session = session();
		$userID = $session->get('id'); // ID user yang login

		$nama         = $this->request->getPost('nama');
		$drive    	  = $this->request->getPost('drive');
		$kategori     = $this->request->getPost('kategori');
		$bulan        = $this->request->getPost('bulan');
		$tahun        = $this->request->getPost('tahun');
		$createdAt    = date('Y-m-d H:i:s');

		$model = new M_absen();

		// Simpan ke tabel user
		$dataUser = [
			'judul_dokumentasi'   => $nama,
			'link_drive'   => $drive,
			'kategori'      => $kategori,
			'bulan'      => $bulan,
			'tahun'      => $tahun,
			'created_at' => $createdAt,
			'created_by' => $userID,
		];
		$model->input('dokumentasi', $dataUser);
		$id_user = $model->insertID(); // Ambil ID user yg baru

		
		// Simpan log aktivitas
		helper('log');
		log_activity($userID, "User " . $id_user ."Menambahkan Dokumentasi: " . $nama);

		return redirect()->to('/home/dokumentasi'); // Ganti sesuai route kamu
	}

	public function keuangan()
	{
		if (in_array(session()->get('level'), range(1, 9))) {
			$bulan_awal = $this->request->getGet('bulan_awal');  // format YYYY-MM
			$bulan_akhir = $this->request->getGet('bulan_akhir');
						$id_kegiatan = $this->request->getGet('id_kegiatan');
	
			$joyce = new M_absen;
			$keuanganModel = new KeuanganModel;
	
			// Ambil pengaturan
			$dataHeader['mey'] = $joyce->settings();
	
			// Ambil semua kegiatan buat dropdown
			$db = \Config\Database::connect();
			$data['kegiatan'] = $db->table('kegiatan')->where('deleted_at', null)->get()->getResultArray();
	
			// Mulai query builder
			$builder = $keuanganModel->where('deleted_at', null);
	
			// Filter bulan (format YYYY-MM)
			if ($bulan_awal && $bulan_akhir) {
				$builder->where('DATE_FORMAT(tanggal, "%Y-%m") >=', $bulan_awal)
						->where('DATE_FORMAT(tanggal, "%Y-%m") <=', $bulan_akhir);
			}
			
	
			// Filter berdasarkan kegiatan
			if (!empty($id_kegiatan)) {
				$builder = $builder->where('id_kegiatan', $id_kegiatan);
			}
	
			// Ambil data keuangan yang sudah difilter
			$keuangan = $builder->orderBy('tanggal', 'DESC')->findAll();
	
			// Hitung total pemasukan dan pengeluaran
			$totalPemasukan = 0;
			$totalPengeluaran = 0;
	
			foreach ($keuangan as $row) {
				if ($row['tipe'] === 'Pemasukan') {
					$totalPemasukan += $row['jumlah'];
				} elseif ($row['tipe'] === 'Pengeluaran') {
					$totalPengeluaran += $row['jumlah'];
				}
			}
	
			$data['keuangan'] = $keuangan;
			$data['bulan_awal'] = $bulan_awal;
			$data['bulan_akhir'] = $bulan_akhir;
			$data['id_kegiatan'] = $id_kegiatan;
			$data['totalKas'] = $totalPemasukan - $totalPengeluaran;
			$data['totalPemasukan'] = $totalPemasukan;
			$data['totalPengeluaran'] = $totalPengeluaran;
		
			// Ambil profil user
			if (in_array(session()->get('level'), range(1, 7))) {
				$where = ['anggota.id_user' => session()->get('id')];
				$dataUser['prof'] = $joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user', $where);
			} else {
				$where = ['id_user' => session()->get('id')];
				$dataUser['prof'] = $joyce->getWhere('user', $where);
			}
	
			// Gabung semua data ke view
			$headerData = array_merge($dataHeader, $dataUser);
			echo view('header', $headerData);
			echo view('keuangan', $data);
			echo view('footer');
	
			helper('log');
			log_activity(session()->get('id'), 'Mengakses halaman data Keuangan');
	
		} else if (session()->get('level') > 0) {
			return redirect()->to('home/error');
		} else {
			return redirect()->to('home/login');
		}
	}
	

public function inputkeuangan()
{
    $joyce = new M_absen;
    
    // Mengambil data keuangan berdasarkan ID
    $where = ('id_keuangan');
    $wendy['anjas'] = $joyce->tampil('keuangan', $where);
    
    // Mengambil data settings
    $apel['mey'] = $joyce->settings();

    // Ambil data kegiatan yang belum dihapus (deleted_at null)
    $db = \Config\Database::connect();
    $data['kegiatan'] = $db->table('kegiatan')->where('deleted_at', null)->get()->getResultArray();
    $wendy['kegiatan'] = $data['kegiatan'];  // Mengirimkan data kegiatan ke view

    if (session()->get('level') == 1 || session()->get('level') == 2 || session()->get('level') == 3 || session()->get('level') == 4 || session()->get('level') == 5 || session()->get('level') == 6 || session()->get('level') == 7) {
        $where = array('anggota.id_user' => session()->get('id'));
        $hee['prof'] = $joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user', $where);
    } else if (session()->get('level') == 8 || session()->get('level') == 9) {
        $where = array('id_user' => session()->get('id'));
        $hee['prof'] = $joyce->getWhere('user', $where);
    }

    // Menggabungkan data untuk view
    $data = array_merge($apel, $hee, $wendy); // Menambahkan $wendy ke array data
    echo view('header', $data);
    echo view('inputkeuangan', $data);  // Menggunakan $data untuk dikirim ke view
    echo view('footer');
}

	public function savekeuangan()
	{
		$session = session();
		$userID = $session->get('id');
	
		$file        = $this->request->getFile('file');
		$tanggal     = $this->request->getPost('tanggal');
		$keterangan  = $this->request->getPost('keterangan');
		$jumlah      = $this->request->getPost('jumlah');
		$tipe        = $this->request->getPost('tipe');
		$jenis       = $this->request->getPost('jenis');
		$id_kegiatan = $this->request->getPost('id_kegiatan'); // bisa kosong kalau jenis == Umum
		$createdAt   = date('Y-m-d H:i:s');
	
		// Validasi jika jenis Kegiatan tapi tidak ada id_kegiatan
		if ($jenis === 'Kegiatan' && empty($id_kegiatan)) {
			return redirect()->back()->with('error', 'Silakan pilih kegiatan jika jenis adalah Kegiatan.');
		}
	
		// Upload nota
		$newFileName = '';
		if ($file->isValid() && !$file->hasMoved()) {
			$newFileName = time() . '_' . $file->getClientName();
			$file->move('img/', $newFileName);
		}
	
		$model = new M_absen();
	
		$dataUser = [
			'jenis'       => $jenis,
			'id_kegiatan' => ($jenis === 'Kegiatan') ? $id_kegiatan : null,
			'nota'        => $newFileName,
			'tanggal'     => $tanggal,
			'keterangan'  => $keterangan,
			'jumlah'      => $jumlah,
			'tipe'        => $tipe,
			'created_at'  => $createdAt,
			'created_by'  => $userID,
		];
	
		$model->input('keuangan', $dataUser);
	
		helper('log');
		log_activity($userID, "Menambahkan data $tipe - $jenis dengan keterangan: $keterangan");
	
		return redirect()->to('/home/keuangan')->with('success', 'Data keuangan berhasil disimpan.');
	}
	
	public function exportExcel()
{
    // Ambil filter dari URL query string
    $bulan_awal = $this->request->getGet('bulan_awal');
    $bulan_akhir = $this->request->getGet('bulan_akhir');
    $id_kegiatan = $this->request->getGet('id_kegiatan');

    // Menyiapkan database dan query builder
    $db = \Config\Database::connect();
    $builder = $db->table('keuangan')->where('deleted_at', null);

    // Filter berdasarkan bulan
    if ($bulan_awal && $bulan_akhir) {
        $startDate = $bulan_awal . '-01';  // Menentukan awal bulan
        $endDate = date('Y-m-t', strtotime($bulan_akhir));  // Menentukan akhir bulan
        $builder->where('tanggal >=', $startDate)
                ->where('tanggal <=', $endDate);
    }

    // Filter berdasarkan kegiatan
    if ($id_kegiatan) {
        $builder->where('id_kegiatan', $id_kegiatan);
    }

    // Ambil data yang sudah difilter
    $data = $builder->orderBy('tanggal', 'ASC')->get()->getResultArray();

    if (empty($data)) {
        echo "Data kosong untuk filter yang diberikan.";
        return;
    }

    // Excel output
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Keuangan.xls");

    echo "<table border='1'>";
    echo "<tr><th colspan='4'><h2>Laporan Keuangan Kas OSIS</h2></th></tr>";
    echo "<tr><td colspan='4'><strong>Periode: " . $bulan_awal . " s.d. " . $bulan_akhir . "</strong></td></tr>";
    echo "<tr><th>Tanggal</th><th>Keterangan</th><th>Pemasukan</th><th>Pengeluaran</th></tr>";

    $totalPemasukan = 0;
    $totalPengeluaran = 0;

    foreach ($data as $row) {
        $pemasukan = ($row['tipe'] === 'Pemasukan') ? number_format($row['jumlah'], 0, ',', '.') : '';
        $pengeluaran = ($row['tipe'] === 'Pengeluaran') ? number_format($row['jumlah'], 0, ',', '.') : '';

        if ($row['tipe'] === 'Pemasukan') $totalPemasukan += $row['jumlah'];
        if ($row['tipe'] === 'Pengeluaran') $totalPengeluaran += $row['jumlah'];

        echo "<tr>
            <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>
            <td>{$row['keterangan']}</td>
            <td>{$pemasukan}</td>
            <td>{$pengeluaran}</td>
        </tr>";
    }

    echo "<tr><td colspan='4'></td></tr>";
    echo "<tr><td colspan='3'><strong>Total Pemasukan</strong></td><td><strong>" . number_format($totalPemasukan, 0, ',', '.') . "</strong></td></tr>";
    echo "<tr><td colspan='3'><strong>Total Pengeluaran</strong></td><td><strong>" . number_format($totalPengeluaran, 0, ',', '.') . "</strong></td></tr>";
    echo "<tr><td colspan='3'><strong>Total Kas OSIS</strong></td><td><strong>" . number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') . "</strong></td></tr>";
    echo "</table>";
    exit;
}
public function input_lpj($id_kegiatan)
{
    // Load model kegiatan dan data kegiatan
    $kegiatanModel = new KegiatanModel();
    $kegiatan = $kegiatanModel->find($id_kegiatan);
    
    if (!$kegiatan) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan.');
    }
	$joyce= new M_absen;

	$apel['mey']=$joyce->settings();

	if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
		$where=array('anggota.id_user' => session()->get('id'));
		$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
	}else if (session()->get('level')==8 || session()->get('level')== 9) {
		$where=array('id_user' => session()->get('id'));
		$hee['prof']=$joyce->getWhere('user', $where);
	}

		$data = array_merge($apel, $hee);
		echo view('header',$data);
    // Tampilkan halaman form LPJ
	echo view('inputlpj', ['kegiatan' => $kegiatan]); // <-- ini benar
}
public function submit_lpj($id_kegiatan)
{

    $tipe = $this->request->getPost('tipe');
    $jumlah = $this->request->getPost('jumlah');
    $sumber = $this->request->getPost('sumber');
    $penggunaan = $this->request->getPost('penggunaan');

    // Validasi manual
    $hasError = false;
    $message = '';

    for ($i = 0; $i < count($tipe); $i++) {
        if (empty($tipe[$i]) || empty($jumlah[$i])) {
            $hasError = true;
            $message = 'Tipe dan jumlah wajib diisi.';
            break;
        }

        if ($tipe[$i] == 'Pemasukan' && empty($sumber[$i])) {
            $hasError = true;
            $message = 'Sumber wajib diisi untuk tipe masuk.';
            break;
        }

        if ($tipe[$i] == 'Pengeluaran' && empty($penggunaan[$i])) {
            $hasError = true;
            $message = 'Penggunaan wajib diisi untuk tipe keluar.';
            break;
        }
    }

    if ($hasError) {
        return redirect()->back()->withInput()->with('error', $message);
    }

    // Simpan data ke database
    $model = new M_LPJ();

    for ($i = 0; $i < count($tipe); $i++) {
        $model->save([
            'id_kegiatan' => $id_kegiatan,
            'tipe'        => $tipe[$i],
            'jumlah'      => $jumlah[$i],
            'sumber'      => $tipe[$i] == 'Pemasukan' ? $sumber[$i] : null,
            'penggunaan'  => $tipe[$i] == 'Pengeluaran' ? $penggunaan[$i] : null,
        ]);
    }

    return redirect()->to(base_url('home/kegiatan/' . $id_kegiatan))->with('success', 'Data LPJ berhasil disimpan.');
}


public function view($id_kegiatan)
{
    $kegiatanModel = new KegiatanModel();
    $lpjModel = new LpjModel();
    
    // Ambil data kegiatan
    $kegiatan = $kegiatanModel->find($id_kegiatan);
    
    if (!$kegiatan) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Kegiatan tidak ditemukan.');
    }

    // Ambil data LPJ jika sudah disubmit
    $lpj = $lpjModel->where('id_kegiatan', $id_kegiatan)->first();

    return view('home/view', [
        'kegiatan' => $kegiatan,
        'lpj' => $lpj
    ]);
}
public function view_lpj($id_kegiatan)
{
    $model = new M_absen();

    $data['lpj'] = $model->getWhere('lpj', ['id_kegiatan' => $id_kegiatan])->getRow();

    if (!$data['lpj']) {
        return redirect()->to('kegiatan')->with('error', 'LPJ tidak ditemukan.');
    }

    echo view('header');
    echo view('view_lpj', $data); // ini langsung tampilin LPJ-nya
    echo view('footer');
}

public function buat($id_kegiatan)
    {
        $lpjModel = new LpjModel();
        $itemModel = new LpjItemModel();

        // Cek apakah LPJ udah ada
        $lpj = $lpjModel->where('id_kegiatan', $id_kegiatan)->first();
        if ($lpj) {
            $items = $itemModel->where('id_lpj', $lpj['id_lpj'])->findAll();
        } else {
            $lpj = null;
            $items = [];
        }

        return view('home/form', [
            'id_kegiatan' => $id_kegiatan,
            'lpj' => $lpj,
            'items' => $items
        ]);
    }

    public function simpan()
    {
        $lpjModel = new LpjModel();
        $itemModel = new LpjItemModel();

        $id_kegiatan = $this->request->getPost('id_kegiatan');
        $bendahara_id = session()->get('id'); // asumsi login

        // Buat LPJ kalau belum ada
        $lpj = $lpjModel->where('id_kegiatan', $id_kegiatan)->first();
        if (!$lpj) {
            $lpj_id = $lpjModel->insert([
                'id_kegiatan' => $id_kegiatan,
                'id_bendahara' => $bendahara_id
            ]);
        } else {
            $lpj_id = $lpj['id_lpj'];
        }

        // Simpan item LPJ
        $tipe = $this->request->getPost('tipe');
        $jumlah = $this->request->getPost('jumlah');
        $sumber = $this->request->getPost('sumber');
        $penggunaan = $this->request->getPost('penggunaan');

        for ($i = 0; $i < count($tipe); $i++) {
            $itemModel->save([
                'id_lpj' => $lpj_id,
                'tipe' => $tipe[$i],
                'jumlah' => $jumlah[$i],
                'sumber' => $tipe[$i] == 'masuk' ? $sumber[$i] : null,
                'penggunaan' => $tipe[$i] == 'keluar' ? $penggunaan[$i] : null,
            ]);
        }

        return redirect()->to('/home/buat/' . $id_kegiatan)->with('success', 'LPJ berhasil disimpan.');
    }
	public function cetakPdf($id_kegiatan)
{
    $lpjModel = new \App\Models\LpjModel();
    $itemModel = new \App\Models\LpjItemModel();
    $kegiatanModel = new \App\Models\KegiatanModel();

    $kegiatan = $kegiatanModel->find($id_kegiatan);
    $lpj = $lpjModel->where('id_kegiatan', $id_kegiatan)->first();
    $items = [];

    if ($lpj) {
        $items = $itemModel->where('id_lpj', $lpj['id_lpj'])->findAll();
    }

    $html = view('home/pdf', [
        'kegiatan' => $kegiatan,
        'items' => $items
    ]);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("LPJ_{$kegiatan['judul_kegiatan']}.pdf", ["Attachment" => false]);
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
		if (session()->get('level')=='8' || session()->get('level')=='9'){ 
			$joyce= new M_absen;
			$wendy['anjas']=$joyce->activity();
			$apel['mey']=$joyce->settings();

			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}

			$data = array_merge($apel, $hee);
			echo view('header',$data);
			echo view('activity',$wendy);
			echo view('footer');
			helper('log');
			log_activity(session()->get('id'), 'Mengakses halaman data Log Activity');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
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
		if (session()->get('level')=='8' || session()->get('level')=='9'){  
			$joyce= new M_absen;
			$wendy['mey']=$joyce->settings();
			if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
				$where=array('anggota.id_user' => session()->get('id'));
				$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
			}else if (session()->get('level')==8 || session()->get('level')== 9) {
				$where=array('id_user' => session()->get('id'));
				$hee['prof']=$joyce->getWhere('user', $where);
			}


			helper('log');
    		log_activity(session()->get('id'), 'Mengakses halaman setting web');
			$data = array_merge($wendy, $hee);
			echo view('header',$data);
			echo view('web',$wendy);
			echo view('footer');

		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editweb ($id)
	{

		$joyce= new M_absen;
		$wece= array('id' =>$id);
		$wendy['mey']=$joyce->getWhere('setting',$wece);
		$where=('id');
		$apel['mey']=$joyce->settings();
	
		if (session()->get('level')==1 || session()->get('level')== 2 || session()->get('level')== 3 || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 6 || session()->get('level')== 7) {
			$where=array('anggota.id_user' => session()->get('id'));
			$hee['prof']=$joyce->jwhere1('user', 'anggota', 'user.id_user=anggota.id_user',$where);
		}else if (session()->get('level')==8 || session()->get('level')== 9) {
			$where=array('id_user' => session()->get('id'));
			$hee['prof']=$joyce->getWhere('user', $where);
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
            $file->move('img', $newName);
    
            if (!empty($produk['foto']) && file_exists('img/' . $produk['foto'])) {
                unlink('img/' . $produk['foto']);
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
    
        return redirect()->to(base_url('home/web'));
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
			return redirect()->to('/home/login')->with('error', 'Token tidak valid');
		}
	
		$userModel->update($user['id_user'], [
			'password' => $password,
			'reset_token' => null
		]);
	
		return redirect()->to('/home/login')->with('success', 'Password berhasil diubah');
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
		$emailService->setReplyTo('yippiebluu@gmail.com', 'Aplikasi Manajemen OSIS');
		$emailService->setSubject('Permintaan Reset Password - Aplikasi Manajemen OSIS');
	
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
