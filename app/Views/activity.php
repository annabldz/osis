<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">LOG ACTIVITY</h6>
              </div>
            </div>
            <div class="card-body px-3 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <!-- <button class="btn btn-success mb-3"><a href="/absen/inputguru" class="text-white">
                  <i class="material-symbols-rounded opacity-100">add_2</i>
                  </a></button> -->
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama User</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Activity</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wali Kelas</th> -->

                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">IP Address</th>
                      <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $ms = 1;
                      foreach ($anjas as $key => $value) {
                          ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><?= $value->nama_user ?></td>
                      <td><?= $value->activity ?></td>
                      <td><?= $value->created_at ?></td>
                      <td><?= $value->ip_address ?></td>
                      

                      <!-- <td>
                      <a href="<?= base_url('absen/generateguru/'.$value->nik)?>" class="btn btn-info">
                      <i class="material-symbols-rounded opacity-100">qr_code_scanner</i></a>
                      <a href="<?= base_url('absen/editguru/'.$value->id_guru)?>" class="btn btn-warning">
                      <i class="material-symbols-rounded opacity-100">border_color</i></a>
                      <a href="<?= base_url('absen/hapusguru/'.$value->id_guru)?>" class="btn btn-danger">
                      <i class="material-symbols-rounded opacity-100">delete</i></a>

                      </td> -->
                    </tr>
                     <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>