 <main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Data Guru</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/home/dashboard">Home</a></li>
          <li class="breadcrumb-item">Data Master</li>
          <li class="breadcrumb-item active">Guru</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Edit Data Guru</h5>

    <form action="<?= base_url('home/saveguru')?>" method="POST" enctype="multipart/form-data" id="form">
      <table>
        
        <tr>
          <td>Nama Guru:</td>
          <td><input type="text" class="form-control" id="nama"name="nama" value="<?= $anjas->nama_guru ?>"></td>
        </tr>
        <tr>
          <td>NIK:</td>
          <td><input type="text" class="form-control" id="nik" name="nik"  value="<?= $anjas->nik ?>"></td>
        </tr>
        
        
        <tr>
          <td></td>
          <td>
            <input type="hidden" value="<?= $anjas->id_guru ?>" name="id">
             <input type="hidden" value="<?= $user->id_user ?>" name="user">
            <button type="submit" class="btn btn-primary">Simpan</button>
            
          </td>
        </tr>
      </table>
    </form>
    <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script>

    