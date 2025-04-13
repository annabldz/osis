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
      <div class="col-lg-4 col-md-6 col-12 text-center">
        <h4>Link Reset Terkirim</h4>
        <p>Link reset password akan dikirim ke <strong><?= session()->getFlashdata('masked_email') ?></strong></p>
        <a href="<?= base_url('absen/login') ?>" class="btn btn-dark mt-3">Kembali ke Login</a>
      </div>
    </div>
  </main>
</body>
</html>
