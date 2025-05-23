<div class="container-fluid px-2 px-md-4">
      <!-- <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');"> -->
        <!-- <span class="mask  bg-gradient-dark  opacity-6"></span> -->
      <!-- </div> -->
      <div class="card card-body mx-2 mx-md-2 mt-n6">
        <div class="row gx-4 mb-2">
          <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
            <img src="<?= base_url('img/'.$prof->foto);?>" class="w-100 border-radius-lg shadow-sm">
            </div>
          </div>
          <div class="col-auto my-auto">
            <div class="h-100">
              <h5 class="mb-1">
              <?= $prof->nama_user ?>
              </h5>
              <p class="mb-0 font-weight-normal text-sm">
              <?= $prof->jabatan ?>
            </p>
            </div>
          </div>
        <div class="row">
          <div class="row">
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Profile Information</h6>
                </div>
                <div class="card-body p-3">
                <hr class="horizontal gray-light my-1">
                  <ul class="list-group">
                  
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">Nama Lengkap:</strong> &nbsp; <?= $prof->nama_anggota ?>
                        </li>
                
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">Email:</strong> &nbsp; <?= $prof->email ?>
                        </li>
                  
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">Menjabat pada tahun:</strong> &nbsp; <?= $prof->tahun_ajaran ?>
                    </li>



                  </ul>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>