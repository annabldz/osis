<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?=base_url ('assets/img/favicon.png')?>">
  <title>
    Absensi Sekolah
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="<?=base_url ('assets/css/nucleo-icons.css')?>" rel="stylesheet" />
  <link href="<?=base_url ('assets/css/nucleo-svg.css')?>" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="<?=base_url ('assets/css/material-dashboard.css?v=3.2.0')?>" rel="stylesheet" />
</head>

<body class="bg-gray-200">
  <style> 
  .page-header {
    position: relative;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.bg-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -2;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5); /* Efek gelap biar teks lebih jelas */
    z-index: -1;
}

.container {
    z-index: 1;
}

</style>
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
      <div class="page-header align-items-start min-vh-100">
      <video autoplay loop muted playsinline class="bg-video">
        <source src="<?= base_url('img/background2.mp4')?>" type="video/mp4">
    </video>
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg py-1 pe-0">
                  <h4 class="text-white font-weight-bolder text-center mt-5 mb-0">APLIKASI ABSENSI</h4>

                  <div class="row mt-3">
                    <div class="col-2 text-center ms-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-facebook text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center px-1">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-github text-white text-lg"></i>
                      </a>
                    </div>
                    <div class="col-2 text-center me-auto">
                      <a class="btn btn-link px-3" href="javascript:;">
                        <i class="fa fa-google text-white text-lg"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form id="login-form" role="form" class="text-start" action="<?= base_url('absen/aksi_login')?>" method="post" class="row g-3 needs-validation" novalidate>


                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="user" class="form-control">
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="pass" class="form-control">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LdyAQUrAAAAAGW8NKQGfdpNjTHLqIZ0YFpltHKZ">
                    </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2" onclick="validateCaptcha()">Login</button>
                  </div>
                  <div class="text-center">
                    <a href="/absen/lupa_password" class="text-secondary text-sm">
                      Lupa Password?
                    </a>
                  </div>

                  </p>
                </form>
                <script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    function validateCaptcha() {
        var response = grecaptcha.getResponse();
        if(response.length === 0) {
            alert("Please complete the CAPTCHA before submitting.");
        } else {
            document.getElementById('login-form').submit();
        }
    }
</script>
              </div>
            </div>
          </div>
        </div>
      </div>
 
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="<?= base_url ('assets/js/core/popper.min.js')?>"></script>
  <script src="<?= base_url ('assets/js/core/bootstrap.min.js')?>"></script>
  <script src="<?= base_url ('assets/js/plugins/perfect-scrollbar.min.js')?>"></script>
  <script src="<?= base_url ('assets/js/plugins/smooth-scrollbar.min.js')?>"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?=base_url ('assets/js/material-dashboard.min.js?v=3.2.0')?>"></script>
</body>

</html>