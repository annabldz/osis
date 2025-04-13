 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Rombel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Sekolah</li>
          <li class="breadcrumb-item active">Rombel</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Rombel</h5>

    <form action="<?= base_url('home/saverombel')?>" method="POST">
      <table>
        <tr>
          <td>Nama Rombel:</td>
          <td><input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_rombel ?>"></td>
        </tr>

    </select>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?=$anjas->id_rombel?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>