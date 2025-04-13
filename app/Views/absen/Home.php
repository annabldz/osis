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
	public function form ()
	{
	echo view('inputuser');
		echo view('inputbarang');
		echo view('barangrusak');
		echo view('barangmasuk');
		echo view('barangkeluar');
	}
	public function aksi_login ()
	{
		$a=$this->request->getPost('email');
		$b=$this->request->getPost('pswd');

		$joyce = new M_belajar;
		$data = array(
			"username"=>$a,
			"password"=>md5($b),
		);

		$cek = $joyce->getWhere('user',$data);
		

		if ($cek != null) {

			session()->set('id',$cek->id_user);
			session()->set('u',$cek->username);
			session()->set('level',$cek->level);

			return redirect()->to('home/dashboard');
		}else {
			return redirect()->to('home/login');
		}
	}
	public function login()
	{
		echo view('pages-login');
		
	}
	public function logout(){
		session()->destroy();
		return redirect()->to('home/login');
	}
	public function tabel()
	{
		echo view('navbar');
		echo view('tabeluser');
		echo view('tabelbarang');
		echo view('tabelmasuk');
		echo view('tabelkeluar');
		echo view('tabelkaryawan');
	}
	
	public function dashboard()
	{
		if (session()->get('id')>0) {
		echo view('header');
		echo view('menu');
		echo view('dashboard');
		echo view('footer');
		}else{
			return redirect()->to('home/login');
		}
		
	}

	public function meow()
	{
		if (session()->get('level')==1){ 
		$joyce= new M_belajar;
		$where=('id');
		$wendy['anjas']=$joyce->tampil('meow',$where);
		echo view('header');
		echo view('menu');
		echo view('meow',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function barang()
	{
		if (session()->get('level')==1){ 
		$joyce= new M_belajar;
		$where=('id_barang');
		$wendy['anjas']=$joyce->tampil('barang',$where);
		echo view('header');
		echo view('menu');
		echo view('barang',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
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
	public function contoh()
	{
		echo view ('editnibro');
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

	public function barangk()
	{
		$joyce= new M_belajar;
		$wendy['anjas']=$joyce->join('barang_keluar','barang','barang_keluar.id_barang=barang.id_barang');
		if (session()->get('level')==1 || session()->get('level')==2 || session()->get('level')==3 || session()->get('level')==5) {
		echo view('header');
		echo view('menu');
		echo view('barangk',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editbarangg ($id)
	{
	$joyce= new M_belajar;
		$wece= array('id_bk' =>$id);
		$wendy['anjas']=$joyce->getWhere('barang_keluar',$wece);
		echo view('header');
		echo view('menu');
		echo view('barangkel',$wendy);
		echo view('footer');
	}
	public function hapusbarangg ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_bk' =>$id);
		$wendy['anjas']=$joyce->hapus('barang_keluar',$wece);
		return redirect()->to('home/barangk');
	}
	public function savek ()
	{
		$a=$this->request->getPost('idbb');
		$b=$this->request->getPost('jumlahb');
		$c=$this->request->getPost('tanggalb');
		$d=$this->request->getPost('idbk');
		$joyce= new M_belajar;
		$wece= array('id_bk' =>$d);
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_keluar"=>$c,
			
		);
		$joyce->edit('barang_keluar',$data,$wece);
		return redirect()->to('home/barangk');
	}
	public function tbk()
	{
		$joyce= new M_belajar;
		$where=('id_bk');
		$wendy['anjas']=$joyce->tampil('barang',$where);
		echo view('header');
		echo view('menu');
		echo view('tbk',$wendy);
		echo view('footer');
	}
	public function savebmk ()
	{
		$a=$this->request->getPost('idb');
		$b=$this->request->getPost('jumlah');
		$c=$this->request->getPost('tanggal');
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_keluar"=>$c,
		);

		$joyce= new M_belajar;
		$joyce->input('barang_keluar',$data);
		return redirect()->to('home/barangk');
	}


	public function barangr()
	{
		$joyce= new M_belajar;
		$wendy['anjas']=$joyce->join('barang_rusak','barang','barang_rusak.id_barang=barang.id_barang');
		if (session()->get('level')=='1' || session()->get('level')=='2' || session()->get('level')=='3') {

		echo view('header');
		echo view('menu');
		echo view('barangr',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function hapusbarangr ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_br' =>$id);
		$wendy['anjas']=$joyce->hapus('barang_rusak',$wece);
		return redirect()->to('home/barangr');
	}
	public function editbarangr ($id)
	{
	$joyce= new M_belajar;
		$wece= array('id_barang' =>$id);
		$wendy['anjas']=$joyce->getWhere('barang_rusak',$wece);
		echo view('header');
		echo view('menu');
		echo view('barangrus',$wendy);
		echo view('footer');
	}
	public function saverus ()
	{
		$a=$this->request->getPost('idb');
		$b=$this->request->getPost('jumlah');
		$c=$this->request->getPost('tanggal');
		$d=$this->request->getPost('idbr');
		$joyce= new M_belajar;
		$wece= array('id_br' =>$d);
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_rusak"=>$c,
			
		);
		$joyce->edit('barang_rusak',$data,$wece);
		return redirect()->to('home/barangr');
	}
	public function tbr()
	{
		$joyce= new M_belajar;
		$where=('id_br');
		$wendy['anjas']=$joyce->tampil('barang',$where);
		echo view('header');
		echo view('menu');
		echo view('tbr',$wendy);
		echo view('footer');
	}
	public function savebrr ()
	{
		$a=$this->request->getPost('idb');
		$b=$this->request->getPost('jumlah');
		$c=$this->request->getPost('tanggal');
		$data = array(
			"id_barang"=>$a,
			"jumlah"=>$b,
			"tanggal_rusak"=>$c,
		);

		$joyce= new M_belajar;
		$joyce->input('barang_rusak',$data);
		return redirect()->to('home/barangr');
	}


		public function karyawan()
	{
		$joyce= new M_belajar;
		$wendy['anjas']=$joyce->join('karyawan','user','karyawan.id_user=user.id_user');
		if (session()->get('level')=='1') {
		echo view('header');
		echo view('menu');
		echo view('karyawan',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}
	public function editkaryawan ($id)
	{
		$joyce= new M_belajar;
		$wece= array('karyawan.id_user' =>$id);
		$wendy['anjas']=$joyce->joinw('karyawan','user','karyawan.id_user=user.id_user',$wece);
		echo view('header');
		echo view('menu');
		echo view('fkaryawan',$wendy);
		echo view('footer');
	}
	public function hapus_karyawan ($id)
	{
		$Joyce= new M_belajar;
		$wece= array('id_user' =>$id);
		$Joyce->hapus('karyawan',$wece);
		$Joyce->hapus('user',$wece);
		return redirect()->to('home/karyawan');
	}

	public function savekar()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('username');
		$c=$this->request->getPost('lvl');
		$d=$this->request->getPost('nik');
		$e=$this->request->getPost('tmpt');
		$f=$this->request->getPost('tgl');
		$g=$this->request->getPost('kelamin');
		$h=$this->request->getPost('alamat');
		$i=$this->request->getPost('nohp');
		$id=$this->request->getPost('idu');

		$where = array(
				"id_user"=>$id
				);
		$joyce= new M_belajar;
		$data = array(
				"username"=>$b,
				"level"=>$c,
				);
		$joyce->edit('user',$data,$where);
		
		$data2=array(
			"nama"=>$a,
			"nik"=>$d,
			"tempat_lahir"=>$e,
			"tanggal_lahir"=>$f,
			"jenis_kelamin"=>$g,
			"alamat"=>$h,
			"no_hp"=>$i,
		);
		$joyce->edit('karyawan',$data2,$where);
		return redirect ()->to('home/karyawan');
	}
	public function tkar()
	{
		
		echo view('header');
		echo view('menu');
		echo view('tkar');
		echo view('footer');
	}
	public function savekaryawan ()
	{
		$a=$this->request->getPost('nama');
		$b=$this->request->getPost('nik');
		$c=$this->request->getPost('username');
		$d=$this->request->getPost('password');
		$e=$this->request->getPost('level');
		$f=$this->request->getPost('tmpt');
		$g=$this->request->getPost('tgl');
		$h=$this->request->getPost('kelamin');
		$i=$this->request->getPost('alamat');
		$j=$this->request->getPost('nohp');
		$joyce= new M_belajar;
		$data = array(
			"username"=>$c,
			"password"=>$d,
			"level"=>$e,
		);
		
		$joyce->input('user',$data);

		$where=array(
			"username"=>$c,
		);
		$wendy=$joyce->getWhere('user',$where);
		$data2=array(
			"id_user"=>$wendy->id_user,
			"nama"=>$a,
			"nik"=>$b,
			"tempat_lahir"=>$f,
			"alamat"=>$i,
			"tanggal_lahir"=>$g,
			"jenis_kelamin"=>$h,
			"no_hp"=>$j,

		);
		$joyce->input('karyawan',$data2);
		return redirect()->to('home/karyawan');
	}


	public function user()
	{
		$joyce= new M_belajar;
		$where=('id_user');
		$wendy['anjas']=$joyce->tampil('user',$where);
		if (session()->get('level')==1){

		echo view('header');
		echo view('menu');
		echo view('user',$wendy);
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
		$wendy['anjas']=$joyce->getWhere('user',$wece);
		echo view('header');
		echo view('menu');
		echo view('tuser',$wendy);
		echo view('footer');
	}
	public function hapususer ($id)
	{
		$joyce= new M_belajar;
		$wece= array('id_user' =>$id);
		$wendy['anjas']=$joyce->hapus('user',$wece);
		return redirect()->to('home/user');
	}

	public function saveuser ()
	{
		$a=$this->request->getPost('username');
		$b=$this->request->getPost('password');
		$c=$this->request->getPost('level');
		$d=$this->request->getPost('id');

		$joyce= new M_belajar;
		$wece= array('id_user' =>$d);
		$data = array(
			"username"=>$a,
			"password"=>$b,
			"level"=>$c,
			
		);
		$joyce->edit('user',$data,$wece);
		return redirect()->to('home/user');
	}
	public function tuser()
	{
		$joyce= new M_belajar;
		$where=('id_user');
		$wendy['anjas']=$joyce->tampil('user',$where);
		echo view('header');
		echo view('menu');
		echo view('userform',$wendy);
		echo view('footer');
	}
	public function saveform ()
	{
		$a=$this->request->getPost('username');
		$b=$this->request->getPost('password');
		$c=$this->request->getPost('level');
		$data = array(
			"username"=>$a,
			"password"=>$b,
			"level"=>$c,
		);
		$joyce= new M_belajar;
		$joyce->input('user',$data);
		return redirect()->to('home/user');
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

	public function tcpdf()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_masuk','barang','barang_masuk.id_barang=barang.id_barang','tanggal_masuk >=','tanggal_masuk <=', $a, $b);

		$pdf = new TCPDF();
		$pdf->setCreator('TCPDF');
		$pdf->setAuthor('Nama Anda');
		$pdf->setTitle('Laporan Barang Masuk');
		$pdf->setSubject('Laporan PDF');
		$pdf->setKeywords('TCPDF,PDF,laporan,barang,masuk');
		$pdf->AddPage();
		$html = view('lapbmmm',['anjas' => $wendy]);
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('laporan_masuk.pdf','D');
		
	}

	

	public function laporank()
	{
		if (session()->get('level')==1 || session()->get('level')==2){ 
		$joyce= new M_belajar;
		$where=('id_bk');
		$wendy['anjas']=$joyce->tampil('barang_keluar',$where);
		echo view('header');
		echo view('menu');
		echo view('laporank',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}

	public function lapork()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_keluar','barang','barang_keluar.id_barang=barang.id_barang','tanggal_keluar >=','tanggal_keluar <=', $a, $b);
		echo view('lapork',$wendy);
	}

	public function laporkk()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_keluar','barang','barang_keluar.id_barang=barang.id_barang','tanggal_keluar >=','tanggal_keluar <=', $a, $b);
		echo view('laporkk',$wendy);
	}

	public function laporkkk()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_keluar','barang','barang_keluar.id_barang=barang.id_barang','tanggal_keluar >=','tanggal_keluar <=', $a, $b);
		echo view('laporkkk',$wendy);
	}
	public function laporanr()
	{
		if (session()->get('level')==1 || session()->get('level')==2){ 
		$joyce= new M_belajar;
		$where=('id_br');
		$wendy['anjas']=$joyce->tampil('barang_rusak',$where);
		echo view('header');
		echo view('menu');
		echo view('laporanr',$wendy);
		echo view('footer');
		}else if(session()->get('level')>0){
			return redirect()->to('home/error');
		}else{
			return redirect()->to('home/login');
		}
	}

	public function laporr()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_rusak','barang','barang_rusak.id_barang=barang.id_barang','tanggal_rusak >=','tanggal_rusak <=', $a, $b);
		echo view('laporr',$wendy);
	}

	public function laporrr()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_rusak','barang','barang_rusak.id_barang=barang.id_barang','tanggal_rusak >=','tanggal_rusak <=', $a, $b);
		echo view('laporrr',$wendy);
	}

	public function laporrrr()
	{
		$joyce= new M_belajar;
		$a=$this->request->getPost('awal');
		$b=$this->request->getPost('akhir');
		$wendy['anjas']=$joyce->filter('barang_rusak','barang','barang_rusak.id_barang=barang.id_barang','tanggal_rusak >=','tanggal_rusak <=', $a, $b);
		echo view('laporrrr',$wendy);
	}

	
}