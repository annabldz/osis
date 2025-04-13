<div class="row">
    <div class="col-12">
        <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">
                        <?= (session()->get('level') == '3') ? 'HISTORY ABSENSI SAYA' : 'DATA ABSENSI SISWA' ?>
                    </h6>
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
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Absen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Masuk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Pulang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <?php if (session()->get('level') == '1' || session()->get('level') == '2' || session()->get('level') == '4') : ?>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $ms = 1;
                            foreach ($anjas as $key => $value) {
                            ?>
                            <tr>
                                <th scope="row" align="center"><?= $ms++ ?></th>    
                                <td><?= !empty($value->nama_siswa) ? $value->nama_siswa : '-' ?></td>         
                                <td><?= !empty($value->nis) ? $value->nis : '-' ?></td>
                                <td><?= !empty($value->nama_kelas) ? $value->nama_kelas : '-' ?></td>
                                <td><?= !empty($value->tanggal) ? $value->tanggal : '-' ?></td>
                                <td><?= !empty($value->jam_masuk) ? $value->jam_masuk : '-' ?></td>
                                <td><?= !empty($value->jam_pulang) ? $value->jam_pulang : '-' ?></td>
                                <td><?= !empty($value->status) ? $value->status : '-' ?></td>

                                <?php if (session()->get('level') == '1' || session()->get('level') == '2' || session()->get('level') == '4') : ?>
                                <td>
                                    <a href="<?= base_url('absen/editabsensiswa/'.$value->id_absensiswa)?>" class="btn btn-warning"
                                    onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?')">
                                    <i class="material-symbols-rounded opacity-100">border_color</i>
                                    </a>

                                    <?php if (session()->get('level') == '1' || session()->get('level') == '4' ) : ?>
                                    <a href="<?= base_url('absen/hapusAbsensiSiswa/'.$value->id_absensiswa)?>" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="material-symbols-rounded opacity-100">cancel</i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php } ?>
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if (session()->get('level') == '1') : ?>
<div class="table-responsive">
                    <?php if (!empty($deleted_user)): ?>
                    <h2 class="mt-4">Data Absensi Siswa yang Dihapus</h2>
                <table class="table table-striped" id="table15">
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Siswa</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kelas</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Absen</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Masuk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Pulang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                <?php if (session()->get('level') == '1'): ?>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $ms = 1;
                      foreach ($deleted_user as $key => $value) {
                          ?>
                    <tr>
                        <th scope="row" align="center"><?= $ms++ ?></th>    
                        <td><?= !empty($value->nama_siswa) ? $value->nama_siswa : '-' ?></td>         
                        <td><?= !empty($value->nis) ? $value->nis : '-' ?></td>
                        <td><?= !empty($value->nama_kelas) ? $value->nama_kelas : '-' ?></td>
                        <td><?= !empty($value->tanggal) ? $value->tanggal : '-' ?></td>
                        <td><?= !empty($value->jam_masuk) ? $value->jam_masuk : '-' ?></td>
                        <td><?= !empty($value->jam_pulang) ? $value->jam_pulang : '-' ?></td>
                        <td><?= !empty($value->status) ? $value->status : '-' ?></td>

                      <td>
                      <a href="<?= base_url('absen/restoreAbsensiSiswa/' . $value->id_absensiswa) ?>" 
                      class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin merestore data ini?')">
                      <i class="material-symbols-rounded opacity-100">restart_alt</i>
                      <span>Restore</span></a>
                      </td>
                    </tr>
                     <?php } ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada data absensi siswa yang dihapus.</p>
                <?php endif; ?>
            </tbody>
        </table>
            </div>
        </div>
    </section>
</div>
<?php endif;  ?>