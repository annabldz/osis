 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Nilai</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Nilai</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Nilai</h5>

    <form action="<?= base_url('home/savenilai')?>" method="POST">
      <table>
        <tr>
          <td>Nama Siswa:</td>
          <td><input type="text" class="form-control" id="siswa"name="siswa" value="<?= $siswaa->id_siswa ?>"></td>
        </tr>
        
        <tr>
          <td>Nilai Pengetahuan:</td>
          <td><input type="text" class="form-control" id="pengetahuan"name="pengetahuan" value="<?= $nilai->nilai_pengetahuan ?>"></td>
        </tr>

        <tr>
          <td>Nilai Keterampilan:</td>
          <td><input type="text" class="form-control" id="keterampilan"name="keterampilan" value="<?= $nilai->nilai_keterampilan ?>"></td>
        </tr>
      
        <tr>
          <td>
            <input type="hidden" value="<?=$nilai->id_nilai?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>