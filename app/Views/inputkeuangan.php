<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?=base_url ('assets/img/favicon.png')?>">
  <title>
    Manajemen OSIS 
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url ('assets/css/nucleo-icons.css')?>" rel="stylesheet" />
  <link href="<?=base_url ('assets/css/nucleo-svg.css')?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
</head>

 <main id="main" class="main">

    <section class="section">
      <div class="row">
       

          <div class="card">
            <div class="card-body">
              <div class="col-lg-500 col-md-11 col-8 mx-auto">
              <h3 class="card-title">Input Data Keuangan OSIS </h5>

<form action="/home/savekeuangan" method="POST" enctype="multipart/form-data">
  <div class="input-group input-group-static mb-4">
    <label>Jenis:</label>
    <select class="form-control" name="jenis" id="jenis" required>
      <option value="">-- Pilih Jenis --</option>
      <option value="Umum">Umum</option>
      <option value="Kegiatan">Kegiatan</option>
    </select>
  </div>

  <div class="input-group input-group-static mb-4" id="kegiatan-wrapper" style="display: none;">
    <label>Nama Kegiatan:</label>
    <select class="form-control" name="id_kegiatan" id="id_kegiatan">
      <option value="">-- Pilih Kegiatan --</option>
      <?php foreach ($kegiatan as $k): ?>
        <option value="<?= $k['id_kegiatan'] ?>"><?= $k['judul_kegiatan'] ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Tanggal:</label>
    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $anjas->tanggal ?>" required>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Keterangan:</label>
    <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $anjas->keterangan ?>" required>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Jumlah:</label>
    <input type="text" class="form-control" id="jumlah" placeholder="Masukkan Jumlah" autocomplete="off">
    <input type="hidden" name="jumlah" id="jumlah_hidden">
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Tipe:</label>
    <select class="form-control" name="tipe" required>
      <option value="">Pilih Tipe</option>
      <option value="Pemasukan">Pemasukan</option>
      <option value="Pengeluaran">Pengeluaran</option>
    </select>
  </div>

  <div class="input-group input-group-static mb-4">
    <label>Bukti Nota:</label>
    <input type="file" class="form-control" name="file" accept="image/*" required>
  </div>

  <input type="hidden" value="<?= $anjas->id_keuangan ?>" name="id">
  <input type="hidden" name="created_at" value="<?= date('Y-m-d H:i:s') ?>">
  <input type="hidden" name="created_by" value="<?= session()->get('id') ?>">

  <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
</form>

<script>
  const inputTampil = document.getElementById('jumlah');
  const inputAsli = document.getElementById('jumlah_hidden');

  inputTampil.addEventListener('input', function () {
    let angka = inputTampil.value.replace(/\D/g, '');
    inputTampil.value = new Intl.NumberFormat('id-ID').format(angka);
    inputAsli.value = angka;
  });

  // Toggle kegiatan dropdown
  const jenisSelect = document.getElementById('jenis');
  const kegiatanWrapper = document.getElementById('kegiatan-wrapper');
  const idKegiatan = document.getElementById('id_kegiatan');

  jenisSelect.addEventListener('change', function () {
    if (this.value === 'Kegiatan') {
      kegiatanWrapper.style.display = 'block';
      idKegiatan.setAttribute('required', 'required');
    } else {
      kegiatanWrapper.style.display = 'none';
      idKegiatan.removeAttribute('required');
    }
  });
</script>
