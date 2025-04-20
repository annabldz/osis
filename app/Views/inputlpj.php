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
              <h3 class="card-title">Input LPJ OSIS </h5>

              <?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger">
    <?= session()->getFlashdata('error') ?>
  </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
  </div>
<?php endif; ?>

<form action="<?= base_url('home/submit_lpj/' . $kegiatan['id_kegiatan']) ?>" method="post">
    <input type="hidden" name="id_kegiatan" value="<?= $id_kegiatan ?>">

    <div id="item-wrapper">
    <div class="row mb-2 item-row">
    <div class="col-md-2">
                <select name="tipe[]" class="form-select" onchange="toggleFields(this)">
                    <option value="masuk">Masuk</option>
                    <option value="keluar">Keluar</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="jumlah[]" class="form-control" placeholder="Jumlah">
            </div>
            <div class="col-md-4 sumber-field">
                <input type="text" name="sumber[]" class="form-control" placeholder="Sumber">
            </div>
            <div class="col-md-4 penggunaan-field d-none">
                <input type="text" name="penggunaan[]" class="form-control" placeholder="Penggunaan">
            </div>
            <div class="col-md-2">
        <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem(this)">-</button>
    </div>
        </div>

    <button type="button" onclick="tambahItem()" class="btn btn-sm btn-secondary">+ Tambah</button>

    <button type="submit" class="btn btn-primary">Simpan LPJ</button>
    </div>

</form>

<?php if ($lpj): ?>
    <hr>
    <h4>Daftar LPJ Tersimpan</h4>
    <a href="<?= base_url('lpj/pdf/' . $id_kegiatan) ?>" class="btn btn-danger" target="_blank">
    Export PDF
</a>

    <table class="table table-bordered">
        <tr>
            <th>Tipe</th><th>Jumlah</th><th>Sumber</th><th>Penggunaan</th>
        </tr>
        <?php foreach ($items as $item): ?>
            <tr>
                <td><?= ucfirst($item['tipe']) ?></td>
                <td>Rp<?= number_format($item['jumlah'], 0, ',', '.') ?></td>
                <td><?= $item['sumber'] ?></td>
                <td><?= $item['penggunaan'] ?></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif; ?>

<script>
function tambahItem() {
    const wrapper = document.querySelector('#item-wrapper');
    const row = wrapper.children[0].cloneNode(true);
    row.querySelectorAll('input').forEach(i => i.value = '');
    wrapper.appendChild(row);
}
function hapusItem(button) {
    const row = button.closest('.item-row');
    const wrapper = document.querySelectorAll('.item-row');
    if (wrapper.length > 1) {
        row.remove();
    } else {
        alert('Minimal satu data harus diisi.');
    }
}

function toggleFields(select) {
    const row = select.closest('.row');
    row.querySelector('.sumber-field').classList.toggle('d-none', select.value === 'keluar');
    row.querySelector('.penggunaan-field').classList.toggle('d-none', select.value === 'masuk');
}
</script>

