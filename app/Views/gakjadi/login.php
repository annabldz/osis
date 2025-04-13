<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manajemen OSIS</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css')?>">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css')?>">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= base_url('img/osis.png')?>" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg position-relative">
                <video autoplay muted loop playsinline class="bg-video">
                    <source src="<?= base_url('img/background3.mp4') ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
        <div class="card col-lg-4 mx-auto position-relative" style="z-index: 2;">
        <div class="card-body px-5 py-5">
                <h3 class="card-title text-center mb-3">Login</h3>
                <form id="login-form" role="form" class="text-start" action="<?= base_url('home/aksi_login')?>" method="post" class="row g-3 needs-validation" novalidate>
                  <div class="form-group">
                    <label>Username </label>
                    <input type="text" name="user" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Password </label>
                    <input type="password" name="pass" class="form-control p_input">
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot password</a>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LfA0g0rAAAAAPfgPJmrXOBiSaHxxmDIUjM9bTcW" data-theme="dark">
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-fw enter-btn" onclick="validateCaptcha()">Login</button>
                    <!-- <button type="button" class="btn btn-primary btn-fw"> -->
                  </div>
                  <!-- <div class="d-flex">
                    <button class="btn btn-facebook mr-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p> -->
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
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js')?>"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?= base_url('assets/js/off-canvas.js')?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js')?>"></script>
    <script src="<?= base_url('assets/js/misc.js')?>"></script>
    <script src="<?= base_url('assets/js/settings.js')?>"></script>
    <script src="<?= base_url('assets/js/todolist.js')?>"></script>
    <!-- endinject -->
  </body>
</html>