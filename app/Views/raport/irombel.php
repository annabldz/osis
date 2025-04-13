<main id="main" class="main">
<div class="pagetitle">
      <h1>Input Rombel</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url ('home/dashboard')?>">Home</a></li>
          <li class="breadcrumb-item">Rombel</li>
          <li class="breadcrumb-item active">Input Rombel</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Rombel</h5>

  <form action="/home/saveirombel" method="POST" enctype="multipart/form-data">
    <table>
      
      <tr>
         <label for="nama" class="form-label">Nama Rombel:</label>
        <input type="text" class="form-control" name="nama">
      </tr>
      <tr>
         <label for="kelas" class="form-label">Kelas:</label>
        <input type="text" class="form-control" name="kelas">
      </tr>
     <tr>
         <label for="guru" class="form-label">Nama Guru:</label>
        <input type="text" class="form-control" name="guru">
      </tr>
      
  <pre></pre>
        <td>
      <button type="submit" class="btn btn-primary" name="hasil">Simpan</button>
        </td>
      </tr>
    </table>
  </form>