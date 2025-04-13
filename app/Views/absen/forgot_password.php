<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password</title>
  <link href="<?= base_url('assets/css/material-dashboard.css?v=3.2.0') ?>" rel="stylesheet" />
</head>
<body class="bg-gray-200">
  <main class="main-content mt-0">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
      <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
          <div class="card-header text-center">
            <h4>Lupa Password</h4>
            <p class="mb-0">Masukkan username kamu</p>
          </div>
          <div class="card-body">
            <form method="post" action="<?= base_url('absen/kirim_reset_password') ?>">
            <div class="mb-3">

                <label>Username</label>
                <div>
                <div class="input-group input-group-outline mb-3">

                <input type="text" name="username" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-dark w-100">Kirim Link Reset</button>
            </form>
            <div class="text-center mt-3">
              <a href="<?= base_url('absen/login') ?>">← Kembali ke Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
