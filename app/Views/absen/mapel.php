
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">DATA MAPEL</h6>
              </div>
            </div>
            <div class="card-body px-3 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                  <button class="btn btn-success mb-3"><a href="/absen/inputmapel" class="text-white">
                  <i class="material-symbols-rounded opacity-100">add_2</i>
                  </a></button>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Mapel</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
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
                      <td><?= $value->nama_mapel ?></td>
                      <td>
                      <a href="<?= base_url('absen/editmapel/'.$value->id_mapel)?>" class="btn btn-warning">
                      <i class="material-symbols-rounded opacity-100">border_color</i></a>
                      <a href="<?= base_url('absen/hapusmapel/'.$value->id_mapel)?>" class="btn btn-danger">
                      <i class="material-symbols-rounded opacity-100">delete</i></a>

                      </td>
                    </tr>
                     <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

