

<?php
          if (session()->get('level')==1 || session()->get('level')==4 ){ ?>
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Selamat datang, <?= $anjas->username ?>! <i class="material-symbols-rounded opacity-10">mood</i></h3>
          <p class="mb-4">
            Silahkan melakukan absensi di masing-masing jadwal yang berjalan.
          </p>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">Absensi Siswa</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/absensiswa" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">Absensi Guru</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/absenguru" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
     
      </div>
    </div>
  </div>
 <?php } ?>

 

<?php
          if (session()->get('level')==2  ){ ?>
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Selamat datang, <?= $anjas->username ?>! <i class="material-symbols-rounded opacity-10">mood</i></h3>
          <p class="mb-4">
            Silahkan melakukan absensi di masing-masing jadwal yang berjalan.
          </p>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">History Absensi</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/absenguru" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">Kartu Petugas</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/kartuguru" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
     
      </div>
    </div>
  </div>
 <?php } ?>

 <?php
          if (session()->get('level')==3  ){ ?>
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">Selamat datang, <?= $anjas->username ?>! <i class="material-symbols-rounded opacity-10">mood</i></h3>
          <p class="mb-4">
            Silahkan melakukan absensi di masing-masing jadwal yang berjalan.
          </p>
        </div>

        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">History Absensi</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/absensiswa" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-5 col-lg-10">
          <div class="card">
            <div class="card-body p-4 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-2 text-capitalize">Menu</p>
                  <h4 class="mb-0">Kartu Pelajar</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                  <a href="/absen/kartusiswa" class="btn btn-dark"><i class="material-symbols-rounded opacity-10" >arrow_circle_right</i></a>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        
     
      </div>
    </div>
  </div>
 <?php } ?>