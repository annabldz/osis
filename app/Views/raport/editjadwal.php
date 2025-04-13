 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Jadwal</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Jadwal</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Jadwal</h5>

    <form action="<?= base_url('home/savejadwal')?>" method="POST">
      <table>
        <tr>
          <td>Nama Guru:</td>
          <td><input type="text" class="form-control" id="guru" name="guru" value="<?= $guru->id_guru ?>"></td>
        </tr>
        
       <tr>
          <td>Sesi:</td>
          <td><input type="text" class="form-control" id="sesi"name="sesi" value="<?= $jadwal->sesi ?>"></td>
        </tr>

          <tr>
          <td>Jam Sesi:</td>
          <td><input type="text" class="form-control" id="jam"name="jam" value="<?= $jadwal->jam_sesi ?>"></td>
        </tr>
      
        <tr>
          <td>
            <input type="hidden" value="<?= $jadwal->id_jadwal ?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>