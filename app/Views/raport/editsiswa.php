 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Siswa</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Siswa</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Siswa</h5>

    <form action="<?= base_url('home/savesiswa')?>" method="POST">
      <table>
         <tr>
          <td>NIS:</td>
          <td><input type="text" class="form-control" id="nis" name="nis"  value="<?=$anjas->nis?>"></td>
        </tr>
        <tr>
          <td>Nama Siswa:</td>
          <td><input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_siswa ?>"></td>
        </tr>
         <tr>
          <td>Rombel:</td>
          <td><input type="text" class="form-control" id="rombel"name="rombel" value="<?= $anjas->nama_rombel ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?=$anjas->id_siswa?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>