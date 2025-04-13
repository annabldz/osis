<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <?php
          if (session()->get('level')==1){ ?>
      
      <li class="nav-heading">Data Master</li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/user">
          <i class="bi bi-list-ul"></i><span>Data User</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/guru">
          <i class="bi bi-list-ul"></i><span>Data Guru</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/siswa">
          <i class="bi bi-list-ul"></i><span>Data Siswa</span>
        </a>
      </li><!-- End Components Nav -->
      <?php } ?>
      <?php
          if (session()->get('level')==1 || session()->get('level')==2){ ?>
      <li class="nav-heading">Data Sekolah</li>
      <?php } ?>
      <?php
          if (session()->get('level')==1){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/kelas">
          <i class="bi bi-list-ul"></i><span>Kelas</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/rombel">
          <i class="bi bi-list-ul"></i><span>Rombel</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/mapel">
          <i class="bi bi-list-ul"></i><span>Data Mapel</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/blok">
          <i class="bi bi-list-ul"></i><span>Data Blok</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/jadwal">
          <i class="bi bi-list-ul"></i><span>Data Jadwal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/nilai">
          <i class="bi bi-list-ul"></i><span>Data Nilai</span>
        </a>

      </li>
      <?php } ?>
      <?php 
      if (session()->get('level')==1 || session()->get('level')==2){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/laporanblok">
          <i class="bi bi-list-ul"></i><span>Laporan Nilai Per Blok</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-list-ul"></i><span>Laporan Nilai Per Semester</span>
        </a>
      </li>
       <?php } ?>
      <li class="nav-heading">Option</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="/home/logout">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li><!-- End Login Page Nav -->
    </ul>

  </aside><!-- End Sidebar-->