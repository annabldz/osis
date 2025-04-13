 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Form Edit Barang</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Barang</h5>

    <form action="<?= base_url('home/saveb')?>" method="POST">
      <table>
        
        <tr>
          <td>Kode Barang</td>
          <td><input type="text" class="form-control" id="kode"name="kode" value="<?= $anjas->kode_barang ?>"></td>
        </tr>
        <tr>
          <td>Nama Barang</td>
          <td><input type="text" class="form-control" id="nama" name="nama"  value="<?=$anjas->nama_barang?>"></td>
        </tr>
        <tr>
          <td>Stok</td>
          <td><input type="text" class="form-control" id="stok"name="stok" value="<?= $anjas->stok ?>"></td>
        </tr>
        <tr>
          <td>Foto Barang</td>
          <td><input type="file" class="form-control" id="file"name="file" ?>"></td>
        </tr>
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?=$anjas->id_barang?>" name="id">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>