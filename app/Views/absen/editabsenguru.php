<main id="main" class="main">
    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-500 col-md-11 col-8 mx-auto">
              <h3 class="card-title">Edit Absensi Guru</h3>

            <div class="card-body px-3 pb-2">
              <div class="table-responsive p-0">

                <table class="table align-items-center justify-content-center mb-0">
                  <form action="<?= base_url('absen/saveabsenguru')?>" method="POST" enctype="multipart/form-data" id="form">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Guru</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NIK</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jam Absen</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                     
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $ms = 1;
                          ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>    

                      <td>
                        <div class="input-group input-group-outline">
                        <input type="text" class="form-control" id="guru" name="guru" value="<?= $guru2->nama_guru ?>" disabled>
                        </div></td>
                      <td>
                        <div class="input-group input-group-outline">
                        <input type="text" class="form-control" id="nik"name="nik" value="<?= $guru2->nik ?>" disabled>
                        </div></td>                      
                      <td>
                        <div class="input-group input-group-outline">
                        <input type="date" class="form-control" id="tanggal"name="tanggal" value="<?= $absenguru->tanggal ?>" disabled>
                        </div></td>    
                      <td>
                        <div class="input-group input-group-outline">
                        <input type="text" class="form-control" id="jam"name="jam" value="<?= $absenguru->jam_absen ?>">
                        </div></td>
                      
                      <td> 
                        <select class="form-control" name="status">
                          <option value="">Pilih Status</option>
                          <option value="Hadir" <?= ($absenguru->status == 'Hadir') ? 'selected' : '' ?>>Hadir</option>
                          <option value="Izin" <?= ($absenguru->status == 'Izin') ? 'selected' : '' ?>>Izin</option>
                          <option value="Sakit" <?= ($absenguru->status == 'Sakit') ? 'selected' : '' ?>>Sakit</option>
                        </select>
                      </td>

                    </tr>
 
          <td>
            <input type="hidden" value="<?= $jadwal->id_jadwal ?>" name="id">
            <input type="hidden" value="<?= $kelas->id_kelas ?>" name="idkelas">
            <input type="hidden" value="<?= $mapel->id_mapel ?>" name="idmapel">
            <input type="hidden" value="<?= $guru->id_guru ?>" name="idguru">
            <input type="hidden" value="<?= $absenguru->id_absenguru ?>" name="idabsen">
            <button type="submit" class="btn btn-dark" align="right"
            onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">Simpan</button>
          </td>
        </tr>
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

