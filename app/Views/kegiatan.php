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

#calendar {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
</style>

<div class="row">
  <div class="col-12">
  <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">DATA KEGIATAN OSIS</h6>
        </div>
      </div>
      
      <div class="card-body px-3 pb-2">
      <button class="btn btn-success mb-3"><a href="/home/inputkegiatan" class="text-white"
                    onclick="return confirm('Apakah Anda yakin ingin menambah data kegiatan?')">
                    <i class="material-symbols-rounded opacity-100">add_2</i> Tambah Kegiatan OSIS
                    </a></button>
        <ul class="nav nav-pills" id="statusTab" role="tablist">
          <li class="nav-item" role="presentation">
            <a class="nav-link active" id="waitingTab" data-bs-toggle="pill" href="#waiting" role="tab" aria-controls="waiting" aria-selected="true">Menunggu Persetujuan</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="runningTab" data-bs-toggle="pill" href="#running" role="tab" aria-controls="running" aria-selected="false">Berjalan</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="completedTab" data-bs-toggle="pill" href="#completed" role="tab" aria-controls="completed" aria-selected="false">Selesai</a>
          </li>
          <li class="nav-item" role="presentation">
            <a class="nav-link" id="rejectedTab" data-bs-toggle="pill" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">Ditolak</a>
          </li>
        </ul>

        <div class="tab-content" id="statusTabContent">
          <!-- Menunggu Persetujuan -->
          <div class="tab-pane fade show active" id="waiting" role="tabpanel" aria-labelledby="waitingTab">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bagian Proker</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Proposal</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $ms = 1;
                  foreach ($anjas as $key => $value):
                    if ($value->status_kegiatan == 'Menunggu Persetujuan'):
                  ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><?= $value->judul_proker ?></td>
                      <td><?= $value->judul_kegiatan ?></td>
                      <td><?= $value->tanggal_kegiatan ?></td>
                      <td><?= $value->waktu ?></td>
                      <td><?= $value->lokasi ?></td>
                      <td>
                        <?php if ($value->proposal_file): ?>
                          <a href="<?= base_url('uploads/proposal/' . $value->proposal_file) ?>" target="_blank" class="badge bg-primary text-white">Lihat</a>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($value->komentar): ?>
                          <?= $value->komentar ?>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge bg-warning text-dark"><?= $value->status_kegiatan ?></span>
                      </td>
                      <td>
                      <?php if ($value->status_kegiatan == 'Menunggu Persetujuan'): ?>
                        <!-- Tombol buka modal komentar -->
                        <button class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('setujui', <?= $value->id_kegiatan ?>)">
                            <i class="material-symbols-rounded opacity-100">check_circle</i> Setujui
                        </button>
                        <button class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('tolak', <?= $value->id_kegiatan ?>)">
                            <i class="material-symbols-rounded opacity-100">cancel</i> Tolak
                        </button>

                        <div class="modal fade" id="komentarModal<?= $value->id_kegiatan ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="<?= base_url('/home/proses_kegiatan/' . $value->id_kegiatan) ?>">
      <input type="hidden" name="aksi" id="aksiField<?= $value->id_kegiatan ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tulis Komentar</h5>
        </div>
        <div class="modal-body">
          <textarea name="komentar" class="form-control" placeholder="Tulis komentar sebelum memproses..." required></textarea> 
                        
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </div>
    </form>
  </div>
</div>
                    <?php endif; ?>

                  

                        <!-- <button class="btn btn-success mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('setujui', <?= $value->id_kegiatan ?>)">
                          <i class="material-symbols-rounded opacity-100">check_circle</i> Setujui
                        </button>
                        <button class="btn btn-danger mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('tolak', <?= $value->id_kegiatan ?>)">
                          <i class="material-symbols-rounded opacity-100">cancel</i> Tolak
                        </button> -->
                      </td>
                    </tr>
                  <?php endif; endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Berjalan -->
          <div class="tab-pane fade" id="running" role="tabpanel" aria-labelledby="runningTab">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bagian Proker</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Proposal</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $ms = 1;
                  foreach ($anjas as $key => $value):
                    if ($value->status_kegiatan == 'Berjalan'):
                  ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><?= $value->judul_proker ?></td>
                      <td><?= $value->judul_kegiatan ?></td>
                      <td><?= $value->tanggal_kegiatan ?></td>
                      <td><?= $value->waktu ?></td>
                      <td><?= $value->lokasi ?></td>
                      <td>
                        <?php if ($value->proposal_file): ?>
                          <a href="<?= base_url('uploads/proposal/' . $value->proposal_file) ?>" target="_blank" class="badge bg-primary text-white">Lihat</a>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($value->komentar): ?>
                          <?= $value->komentar ?>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge bg-info"><?= $value->status_kegiatan ?></span>
                      </td>
                      <!-- Tampilkan link LPJ jika status kegiatan sudah selesai -->
                   
                      <td>
                      <?php if ($value->status_kegiatan == 'Berjalan'): ?>
                        <!-- Selesaikan langsung (atau bisa pakai modal juga jika mau) -->
                        <!-- <button class="btn btn-info mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('selesai', <?= $value->id_kegiatan ?>)">
                            <i class="material-symbols-rounded">done_all</i> Selesaikan
                        </button> -->
                        <!-- <a href="<?= base_url('home/input_lpj/' . $value->id_kegiatan); ?>" class="btn btn-success">Selesaikan</a> -->
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLPJ<?= $value->id_kegiatan ?>" data-id="<?= $value->id_kegiatan ?>"> Selesaikan </button>

                    <?php endif; ?>
                        <!-- <button class="btn btn-info mt-1" data-bs-toggle="modal" data-bs-target="#komentarModal<?= $value->id_kegiatan ?>" onclick="setAksi('selesai', <?= $value->id_kegiatan ?>)">
                          <i class="material-symbols-rounded">done_all</i> Selesaikan
                        </button> -->
                        <!-- Di dalam foreach running kegiatan -->
<div class="modal fade" id="modalLPJ<?= $value->id_kegiatan ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form action="<?= base_url('home/proses_lpj/' . $value->id_kegiatan) ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Input LPJ - <?= $value->judul_kegiatan ?></h5>
        </div>
        <div class="modal-body">
          <div id="lpj-rows-<?= $value->id_kegiatan ?>">
            <div class="row mb-2">
              <div class="col-md-4">
                <select name="tipe[]" class="form-control" onchange="toggleFields(this)">
                  <option value="">Pilih Tipe</option>
                  <option value="Pemasukan">Pemasukan</option>
                  <option value="Pengeluaran">Pengeluaran</option>
                </select>
              </div>
              <div class="col-md-4">
                <input type="text" name="jumlah[]" class="form-control format-rupiah" placeholder="Jumlah (Rp)" required>
              </div>
              <div class="col-md-3 sumber-field">
                <input type="text" name="sumber[]" class="form-control" placeholder="Sumber">
              </div>

              <div class="col-md-3 penggunaan-field d-none">
                <input type="text" name="penggunaan[]" class="form-control" placeholder="Penggunaan">
              </div>
              <div class="col-md-4 bukti-field">
                <input type="file" name="bukti[]" class="form-control" placeholder="Bukti">
              </div>
              <div class="col-md-4 tanggal-field">
                <input type="date" name="tanggal[]" class="form-control" placeholder="Tanggal">
              </div>
            </div>
          </div>
          <button type="button" class="btn btn-sm btn-secondary" onclick="tambahBarisLPJ(<?= $value->id_kegiatan ?>)">+ Tambah Baris</button>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan & Selesaikan</button>
        </div>
      </div>
    </form>
  </div>
</div>

                      </td>
                    </tr>
                  <?php endif; endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Selesai -->
          <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completedTab">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bagian Proker</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Proposal</th>
                    <th>Komentar</th>
                    <th>Status</th>
                    <th>LPJ</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $ms = 1;
                  foreach ($anjas as $key => $value):
                    if ($value->status_kegiatan == 'Selesai'):
                  ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><?= $value->judul_proker ?></td>
                      <td><?= $value->judul_kegiatan ?></td>
                      <td><?= $value->tanggal_kegiatan ?></td>
                      <td><?= $value->waktu ?></td>
                      <td><?= $value->lokasi ?></td>
                      <td>
                        <?php if ($value->proposal_file): ?>
                          <a href="<?= base_url('uploads/proposal/' . $value->proposal_file) ?>" target="_blank" class="badge bg-primary text-white">Lihat</a>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($value->komentar): ?>
                          <?= $value->komentar ?>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      
                      <td>
                        <span class="badge bg-success"><?= $value->status_kegiatan ?></span>
                      </td>
                      <td>
                      <?php if ($value->status_kegiatan == 'Selesai'): ?>
                        <a href="<?= base_url('home/perKegiatan/' . $value->id_kegiatan) ?>">
                            Lihat LPJ
                        </a>
                      <?php endif; ?>
                              </td>
                    </tr>
                  <?php endif; endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Ditolak -->
          <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejectedTab">
            <div class="table-responsive p-0">
              <table class="table align-items-center justify-content-center mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Bagian Proker</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Kegiatan</th>
                    <th>Waktu</th>
                    <th>Lokasi</th>
                    <th>Proposal</th>
                    <th>Komentar</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $ms = 1;
                  foreach ($anjas as $key => $value):
                    if ($value->status_kegiatan == 'Ditolak'):
                  ?>
                    <tr>
                      <th scope="row" align="center"><?= $ms++ ?></th>
                      <td><?= $value->judul_proker ?></td>
                      <td><?= $value->judul_kegiatan ?></td>
                      <td><?= $value->tanggal_kegiatan ?></td>
                      <td><?= $value->waktu ?></td>
                      <td><?= $value->lokasi ?></td>
                      <td>
                        <?php if ($value->proposal_file): ?>
                          <a href="<?= base_url('uploads/proposal/' . $value->proposal_file) ?>" target="_blank" class="badge bg-primary text-white">Lihat</a>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($value->komentar): ?>
                          <?= $value->komentar ?>
                        <?php else: ?>  
                          <span class="badge bg-secondary">Belum ada</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <span class="badge bg-danger"><?= $value->status_kegiatan ?></span>
                      </td>
                    </tr>
                  <?php endif; endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal Komentar -->

<script>
  // Biar id_kegiatan masuk ke form saat tombol diklik
  const modalLPJ = document.getElementById('modalLPJ');
  modalLPJ.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    modalLPJ.querySelector('#id_kegiatan').value = id;
  });
</script>

<script>
  function setAksi(aksi, id) {
    document.getElementById('aksiField' + id).value = aksi;
  }
</script>

<script>

function toggleFields(select) {
    const row = select.closest('.row');
    row.querySelector('.sumber-field').classList.toggle('d-none', select.value === 'Pengeluaran');
    row.querySelector('.penggunaan-field').classList.toggle('d-none', select.value === 'Pemasukan');
}

</script>
<script>
function tambahBarisLPJ(id) {
  const wrapper = document.getElementById('lpj-rows-' + id);
  const row = document.createElement('div');
  row.className = 'row mb-2';
  row.innerHTML = `
    <div class="col-md-4">
      <select name="tipe[]" class="form-control" onchange="toggleFields(this)" required>
        <option value="">Pilih Tipe</option>
        <option value="Pemasukan">Pemasukan</option>
        <option value="Pengeluaran">Pengeluaran</option>
      </select>
    </div>
    <div class="col-md-4">
      <input type="text" name="jumlah[]" class="form-control format-rupiah" placeholder="Jumlah (Rp)" required>
    </div>
    <div class="col-md-3 sumber-field">
      <input type="text" name="sumber[]" class="form-control" placeholder="Sumber">
    </div>
    <div class="col-md-3 penggunaan-field d-none">
      <input type="text" name="penggunaan[]" class="form-control" placeholder="Penggunaan">
    </div>
    <div class="col-md-4 bukti-field">
      <input type="file" name="bukti[]" class="form-control" placeholder="Bukti">
    </div>
    <div class="col-md-4 tanggal-field">
      <input type="date" name="tanggal[]" class="form-control" placeholder="Tanggal">
    </div>
  `;
  function hapusBaris(btn) {
  const row = btn.closest('.row');
  if (row) {
    row.remove();
  }
}

  wrapper.appendChild(row);
}

</script>
<script>
document.addEventListener('input', function(e) {
  if (e.target.classList.contains('format-rupiah')) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = formatRupiah(value);
  }
});

function formatRupiah(angka) {
  return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
</script>
