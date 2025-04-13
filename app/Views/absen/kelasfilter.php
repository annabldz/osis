
<div class="row-g-3">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">DATA KELAS</h6>
              </div>
            </div>
            <div class="card-body px-3 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Siswa</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIS</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kelas</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
            <?php 
            $no = 1;
            if (!empty($siswa)) {
                foreach ($siswa as $value) { ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $value->nama_siswa ?></td>
                        <td><?= $value->nis ?></td>
                        <td><?= $value->nama_kelas ?></td>
                    </tr>
                <?php } 
            } else { ?>
                <tr>
                    <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>
            <?php } ?>
        </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- select siswa.nama_siswa, kelas.nama_kelas from siswa 
join kelas on siswa.id_kelas=kelas.id_kelas 
where kelas.nama_kelas = "RPL XI A" -->

