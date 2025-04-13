<!DOCTYPE html>
<html id="html" lang="id">

<head>
  <meta charset="utf-8" />
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?=base_url ('assets/img/apple-icon.png')?>">
  <link rel="icon" type="image/png" href="<?= base_url('img/'.$mey->foto);?>">
  <title>
  <?= $mey->nama?>
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
  <link id="pagestyle" href="<?=base_url ('assets/css/material-dashboard.css?v=3.2.0')?>" rel="stylesheet" />
</head>

<!DOCTYPE html>
<html lang="en">
 <main id="main" class="main">
<body class="g-sidenav-show  bg-gray-100">
<style>
  .material-icons {
    font-family: 'Material Icons' !important;
    font-weight: normal;
    font-style: normal;
    display: inline-block;
    text-transform: none;
    letter-spacing: normal;
    word-wrap: normal;
    white-space: nowrap;
    direction: ltr;
    font-size: 24px; /* Sesuaikan ukuran */
}
</style>


  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="">
        <img src="<?= base_url('img/'.$mey->foto);?>" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark"><?= $mey->nama?></span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark" href="/home/dashboard">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>  
        <?php
          if (session()->get('level')==9 ){ ?>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/home/activity">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Log Activity</span>
          </a>
        </li>  
        <?php } ?>
        
        <?php
          if ( session()->get('level')==8 || session()->get('level')==9 ){ ?>
           <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Data Organisasi</h6>
        </li>
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/user">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Data User</span>
          </a>
        </li>
        <?php } ?> 
        <?php
          if ( session()->get('level')==1 || session()->get('level')==7 ||session()->get('level')==8 || session()->get('level')==9 )  { ?>
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/anggota">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Data Anggota</span>
          </a>
        </li>
       
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/proker">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Program Kerja</span>
          </a>
        </li>

        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/kegiatan">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Agenda Kegiatan</span>
          </a>
        </li>
        <?php } ?>

        <?php
          if (session()->get('level')==1  || session()->get('level')== 3 || session()->get('level')== 7 || session()->get('level')==8 || session()->get('level')==9 ){ ?>
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/keuangan">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Laporan Keuangan</span>
          </a>
        </li>
        <?php } ?>
        <?php
          if (session()->get('level')==1  || session()->get('level')== 2 || session()->get('level')== 7 || session()->get('level')==8 || session()->get('level')==9 ){ ?>
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/proposal">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Arsip Proposal Kegiatan</span>
          </a>
        </li>
        <?php } ?>
        <?php
          if (session()->get('level')==1  || session()->get('level')== 6  || session()->get('level')== 4 || session()->get('level')== 5 || session()->get('level')== 7 || session()->get('level')==8 || session()->get('level')==9 ){ ?>
        <li class="nav-item">
        <a class="nav-link  text-dark" href="/home/dokumentasi">
        <i class="material-symbols-rounded opacity-5">qr_code_scanner</i>
            <span class="nav-link-text ms-1">Arsip Dokumentasi</span>
          </a>
        </li>
        <?php } ?>
        
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <?php
          if (session()->get('level')==9){ ?>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/home/web">
            <i class="material-symbols-rounded opacity-5">settings</i>
            <span class="nav-link-text ms-1">Web Settings</span>
          </a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/home/profile">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/home/logout">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>

      </ul>

  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>

          <li class="nav-item dropdown pe-3 d-flex align-items-center">
          <div id="google_translate_element"></div>
          <script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement(
            {pageLanguage: 'id', includedLanguages: 'id,en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 
            'google_translate_element'
        );
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

          <!-- <button onclick="gantiBahasa('id')">Indonesia</button>
          <button onclick="gantiBahasa('en')">English</button> -->

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="<?= base_url('img/'.$prof->foto);?>" alt="foto" class="rounded-circle" width="46" height="46">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?= $prof->username?><i class="fas fa-chevron-circle-down"></i></span> 
        </a><!-- End Profile Iamge Icon -->
        
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile"> 
          <li class="dropdown-header">
            <h6><?= $prof->username ?></h6>
            <span><?= session()->get('level') ?> - <?= $prof->status ?></span>
          </li>
          <li> 
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="/absen/profile">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>             
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="/absen/logout">
              <i class="bi bi-box-arrow-right"></i>
              <span>Logout</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <script>
    let idleTime = 0;
    const idleLimit = 10 * 60 * 1000; // 10 menit dalam milidetik

    function resetIdleTime() {
        idleTime = 0;
    }

    function startIdleTimer() {
        setInterval(() => {
            idleTime += 1000; // Tambah waktu idle setiap detik
            if (idleTime >= idleLimit) {
                window.location.href = "<?= base_url('home/logout') ?>"; // Redirect ke logout
            }
        }, 1000);
    }

    // Reset waktu idle jika ada aktivitas
    window.onload = resetIdleTime;
    document.onmousemove = resetIdleTime;
    document.onkeydown = resetIdleTime;
    document.onclick = resetIdleTime;
    document.onscroll = resetIdleTime;

    startIdleTimer();
</script>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
