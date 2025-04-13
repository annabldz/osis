<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password Terkirim</title>
  <link href="<?= base_url('assets/css/material-dashboard.css?v=3.2.0') ?>" rel="stylesheet" />

</head>
<body class="bg-gray-200">
  <main class="main-content mt-0">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">

<form action="<?= base_url('absen/simpan_password_baru') ?>" method="post">
<div class="mb-3">

    <input type="hidden" name="token" value="<?= $token ?>">
    <label>Password Baru:</label>
</div>
<div class="input-group input-group-outline mb-3 align-center">

    <input type="password" name="password" required class="form-control">
</div>
    <button type="submit" class="btn btn-dark mt-3">Simpan</button>
</form>
</div>
  </main>
</body>
</html>
