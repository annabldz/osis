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

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="<?= base_url('assets/img/logo-ct-dark.png')?>" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">Absensi Sekolah</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active bg-gradient-dark text-white" href="/absen/dashboard">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Data Master</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/user">
            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">User</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/guru">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Guru</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/siswa">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Siswa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/kelas">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">Kelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/mapel">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Mapel</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/jadwal">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Jadwal</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Data Absensi</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/absenguru">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Absensi Guru</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/absensiswa">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Absensi Siswa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/laporan">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Laporan Absensi</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/userprofile">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="/absen/logout">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Logout</span>
          </a>
        </li>
       
      </ul>
    </div>
    
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
   
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <!-- <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
        </nav> -->
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
           <!--  <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div> -->
          </div>
         
          <li class="nav-item dropdown pe-3 d-flex align-items-center">
            <script>
            document.getElementById("username").innerText = data.username;
            document.getElementById("profile").src = "<?= base_url('img/') ?>" + data.foto;

            </script>
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
            <a class="dropdown-item d-flex align-items-center" href="/absen/userprof">
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

    </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
<div class="container mt-4">
    <h2 class="text-center">Data User</h2>
    <table class="table table-striped table-bordered" id="userTable">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Username</th>
                <th>Level</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("JavaScript sudah berjalan!");
        
        let tableBody = document.querySelector("#userTable tbody");
        if (!tableBody) {
            console.error("Tabel tidak ditemukan di dalam DOM!");
            return;
        }

        fetch('http://localhost:8080/absen/user')
        .then(response => response.json())
        .then(data => {
            console.log("Data dari API:", data);

            tableBody.innerHTML = "";

            data.forEach((user, index) => {
                let row = `<tr>
                    <td>${index + 1}</td>
                    <td><img src="${user.foto}" width="100" height="100" onerror="this.onerror=null; this.src='http://localhost:8080/assets/img/default.png';"></td>
                    <td>${user.username}</td>
                    <td>${user.level}</td>
                    <td>${user.status}</td>
                    <td>
                        <button onclick="edituser(${user.id_user})">Reset Password</button>
                    </td>
                </tr>`;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        })
        .catch(error => console.error("Error fetch data:", error));
    });

    function edituser(id) {
        alert("Edit data siswa dengan ID: " + id);
        window.location.href = '<?= base_url("absen/edituser/") ?>' + id;
    }
</script>



<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
fetch('http://localhost:8080/absen/user')
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Debugging: Lihat hasil JSON di console

        // Menampilkan nama user di navbar atau profile card
        document.getElementById("username").innerText = data.username;
        document.getElementById("profile").src = "<?= base_url('img/') ?>" + data.foto;
    })
    .catch(error => console.error('Error:', error));
</script>
 -->
