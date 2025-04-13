<style>
  .truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .deskripsi-wrapper a {
    color:rgb(25, 63, 89);
    font-size: 0.85rem;
    font-weight: 600;
  }
  .deskripsi-wrapper a:hover {
    text-decoration: underline;
  }
</style>


    <div class="row">
            <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">PROGRAM KERJA OSIS</h6>
                </div>
                </div>
                <div class="card-body px-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                    <button class="btn btn-success mb-3"><a href="/home/inputproker" class="text-white"
                    onclick="return confirm('Apakah Anda yakin ingin menambah data proker?')">
                    <i class="material-symbols-rounded opacity-100">add_2</i> Tambah Proker
                    </a></button>
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Proker</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi Proker</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pelaksanaan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
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
                        <td><?= $value->judul_proker ?></td>
                        <td style="white-space: normal;">
                            <div class="deskripsi-wrapper">
                                <div class="deskripsi-text truncate-2" id="desc-<?= $value->id_proker ?>">
                                <?= $value->deskripsi_proker ?>
                                </div>
                                <a href="javascript:void(0);" onclick="toggleFullText(<?= $value->id_proker ?>)" id="link-<?= $value->id_proker ?>">Lihat Selengkapnya</a>
                            </div>
                        </td>

                        <td><?= $value->tanggal_pelaksanaan ?></td>
                        <td>
                            <?php
                                $status = $value->status;
                                $badgeClass = '';

                                if ($status == 'Perencanaan') {
                                $badgeClass = 'badge bg-warning text-dark';
                                } elseif ($status == 'Terlaksana') {
                                $badgeClass = 'badge bg-success';
                                } elseif ($status == 'TidakTerlaksana' || $status == 'Tidak Terlaksana') {
                                $badgeClass = 'badge bg-danger';
                                }
                            ?>
                            <span class="<?= $badgeClass ?>"><?= $status ?></span>
                        </td>

                        <td>
                        <a href="<?= base_url('home/editproker/'.$value->id_proker)?>" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?')">
                        <i class="material-symbols-rounded opacity-100">border_color</i>
                        </a>
                        <!-- <a href="<?= base_url('home/hapusproker/'.$value->id_proker)?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="material-symbols-rounded opacity-100">cancel</i>
                        </a>
                         -->

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
                        <script>
  function toggleFullText(id) {
    const desc = document.getElementById('desc-' + id);
    const link = document.getElementById('link-' + id);

    if (desc.classList.contains('truncate-2')) {
      desc.classList.remove('truncate-2');
      link.innerText = 'Sembunyikan';
    } else {
      desc.classList.add('truncate-2');
      link.innerText = 'Lihat Selengkapnya';
    }
  }
</script>
