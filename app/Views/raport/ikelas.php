<main id="main" class="main">
<div class="pagetitle">
      <h1>Input Kelas</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url ('home/dashboard')?>">Home</a></li>
          <li class="breadcrumb-item">Kelas</li>
          <li class="breadcrumb-item active">Input Kelas</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Kelas</h5>

  <form action="/home/saveikelas" method="POST" enctype="multipart/form-data">
    <table>
      
      <tr>
         <label for="nama" class="form-label">Nama Kelas:</label>
        <input type="text" class="form-control" name="nama">
      </tr>
    
    </select>
  </tr>
  <pre></pre>
        <td>
      <button type="submit" class="btn btn-primary" name="hasil">Simpan</button>
        </td>
      </tr>
    </table>
  </form>