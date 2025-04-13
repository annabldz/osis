
<div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">DATA ANGGOTA</h6>
              </div>
            </div>
            <div class="card-body px-3 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center justify-content-center mb-0">
                <button class="btn btn-success mb-3"><a href="/home/inputanggota" class="text-white"
                  onclick="return confirm('Apakah Anda yakin ingin menambah data anggota?')">
                  <i class="material-symbols-rounded opacity-100">add_2</i> Tambah Data Anggota
                  </a></button>
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Anggota</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun Menjabat</th>
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
                      <td><img src="<?= base_url('img/'.$value->foto);?>" width="45px" class="rounded-circle"></td>
                      <td><?= $value->nama_anggota ?></td>
                      <td><?= $value->email ?></td>
                      <td><?= $value->jabatan ?></td>
                      <td><?= $value->tahun_ajaran ?></td>

                      <td>
                      <a href="<?= base_url('home/editanggota/'.$value->id_anggota)?>" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?')">
                      <i class="material-symbols-rounded opacity-100">border_color</i>
                      </a>
                      <a href="<?= base_url('home/hapusanggota/'.$value->id_anggota)?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                      <i class="material-symbols-rounded opacity-100">cancel</i>
                      </a>
                     

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

                      <div class="table-responsive">
                    <?php if (!empty($deleted_user)): ?>
                    <h2 class="mt-4">Data Anggota yang Dihapus</h2>
                <table class="table table-striped" id="table15">
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Foto</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Anggota</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jabatan</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun Menjabat</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                      
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $ms = 1;
                      foreach ($deleted_user as $key => $value) {
                          ?>
                    <tr>
                    <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><img src="<?= base_url('img/'.$value->foto);?>" width="30px"></td>
                      
                      <td><?= $value->nama_anggota ?></td>
                      <td><?= $value->jabatan ?></td>
                      <td><?= $value->tahun_ajaran ?></td>                      

                      <td>
                      <a href="<?= base_url('home/restoreanggota/'.$value->id_anggota)?>" class="btn btn-info"
                      onclick="return confirm('Apakah Anda yakin ingin merestore data ini?')">
                      <i class="material-symbols-rounded opacity-100">autorenew</i></a>

                      </td>
                    </tr>
                     <?php } ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada data anggota yang dihapus.</p>
                <?php endif; ?>
            </tbody>
        </table>
            </div>
        </div>
    </section>
</div>
