<main id="main" class="main">
<div class="pagetitle">
      <h1>Input Form</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url ('home/dashboard')?>">Home</a></li>
          <li class="breadcrumb-item">Input</li>
          <li class="breadcrumb-item active">Input Barang</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Barang</h5>

  <form action="/home/savebrg" method="POST" enctype="multipart/form-data">
    <table>
       <tr>
        <td>Kode Barang</td>
        <td><input type="text" class="form-control" name="kode"></td>
      </tr>
      <tr>
        <td>Nama Barang</td>
        <td><input type="text" class="form-control" name="nama"></td>
      </tr>
      <tr>
        <td>Stok</td>
        <td><input type="text" class="form-control" name="stok"></td>
      </tr>
      <tr>
        <td>Foto</td>
        <td><input type="file" class="form-control" name="file" accept="img/" required></td>
      </tr>
      <tr>
        <td></td>
        <td>
      <button type="submit" class="btn btn-primary" name="hasil">Simpan</button>
        </td>
      </tr>
    </table>
  </form>
    





