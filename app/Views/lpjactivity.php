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

<h2>Daftar LPJ untuk Kegiatan: <?= esc($lpj['judul_kegiatan']) ?></h2>

<?php
    // Inisialisasi total LPJ
    $totalLPJPemasukan = 0;
    $totalLPJPengeluaran = 0;
?>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Sumber</th>
            <th>Penggunaan</th>
            <th>Tanggal</th>
            <th>Bukti</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($lpj['lpj'])): ?>
            <?php
                $no = 1;
                foreach ($lpj['lpj'] as $row):
                    // Hitung total berdasarkan tipe
                    if ($row['tipe'] == 'Pemasukan') {
                        $totalLPJPemasukan += $row['jumlah'];
                    } elseif ($row['tipe'] == 'Pengeluaran') {
                        $totalLPJPengeluaran += $row['jumlah'];
                    }
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['tipe']) ?></td>
                    <td><?= number_format($row['jumlah']) ?></td>
                    <td><?= esc($row['sumber']) ?></td>
                    <td><?= esc($row['penggunaan']) ?></td>
                    <td><?= esc($row['tanggal']) ?></td>
                    <td><img src="<?= base_url('img/' . $row['bukti']) ?>" alt="Bukti" width="60"></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">Belum ada data LPJ untuk kegiatan ini.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if (!empty($lpj['lpj'])): ?>
    <!-- <div class="alert alert-info mt-3"> -->
        <strong>Total Pemasukan LPJ:</strong> Rp<?= number_format($totalLPJPemasukan, 0, ',', '.') ?><br>
        <strong>Total Pengeluaran LPJ:</strong> Rp<?= number_format($totalLPJPengeluaran, 0, ',', '.') ?><br>
        <strong>Sisa Saldo dari LPJ Kegiatan:</strong> <span class="fw-bold">Rp<?= number_format($totalLPJPemasukan - $totalLPJPengeluaran, 0, ',', '.') ?></span>
    <!-- </div> -->
<?php endif; ?>
