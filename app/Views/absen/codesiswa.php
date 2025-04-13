<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Siswa</title>
</head>
<body>
    <h3>QR Code untuk: <?= $siswa['nama_siswa']; ?></h3>
    <img src="<?= base_url('absen/generate/' . $siswa['nis']); ?>" alt="QR Code">
</body>
</html>
