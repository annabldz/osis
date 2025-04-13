<!DOCTYPE html>
<html>
<head>
  <title>Reset Password Terkirim</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
  <div class="text-center">
    <h4 class="mb-3">Verifikasi Terkirim</h4>
    <p class="lead">
      Link verifikasi reset password telah dikirim ke:<br>
      <strong><?= esc($maskedEmail) ?></strong>
    </p>
    <a href="<?= base_url('absen/login') ?>" class="btn btn-dark mt-3">Kembali ke Login</a>
  </div>
</body>
</html>
