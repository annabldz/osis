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
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                    <h6 class="text-white text-capitalize ps-3">DATA KEGIATAN OSIS</h6>
                </div>
                </div>
                <div class="card-body px-3 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                    <button class="btn btn-success mb-3"><a href="/home/inputkegiatan" class="text-white"
                    onclick="return confirm('Apakah Anda yakin ingin menambah data kegiatan?')">
                    <i class="material-symbols-rounded opacity-100">add_2</i> Tambah Kegiatan OSIS
                    </a></button>
                    <thead>
                        <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Bagian Proker</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Kegiatan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Kegiatan</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Waktu</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lokasi</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Proposal</th>
                        <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hasil Dokumentasi</th> -->
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                        <?php
                    if (session()->get('level')==7){ ?>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                        <?php } ?>
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
                        <td><?= $value->judul_kegiatan ?></td>
                        <td><?= $value->tanggal_kegiatan ?></td>
                        <td><?= $value->waktu ?></td>
                        <td><?= $value->lokasi ?></td>
                                        
                          <td>
                            <?php if ($value->proposal_file): ?>
                                <a href="<?= base_url('uploads/proposal/' . $value->proposal_file) ?>" 
                                target="_blank" 
                                class="badge bg-primary text-white" 
                                style="text-decoration: none;">
                                 Lihat
                                </a>
                            <?php else: ?>  
                                <span class="badge bg-secondary">Belum ada</span>
                            <?php endif; ?>
                        </td>
                        <!-- <td>
                            <?php if (!empty($value->link_drive)): ?>
                                <a href="<?= $value->link_drive ?>" target="_blank" class="btn btn-primary btn-sm">
                                    <i class="material-symbols-rounded" style="font-size:16px; vertical-align:middle;">visibility</i> Lihat
                                </a>
                            <?php else: ?>
                                <span class="badge bg-info">Belum ada</span>
                            <?php endif; ?>
                        </td> -->


                          
                        <td>
                            <?php
                                $status = $value->status_kegiatan;
                                $badgeClass = '';

                                if ($status == 'Menunggu Persetujuan') {
                                $badgeClass = 'badge bg-warning text-dark';

                                } elseif ($status == 'Berjalan') {
                                $badgeClass = 'badge bg-info';

                                } elseif ($status == 'Selesai') {
                                $badgeClass = 'badge bg-success';

                                } elseif ($status == 'Ditolak' || $status == 'Ditolak') {
                                $badgeClass = 'badge bg-danger';
                                }
                            ?>
                            <span class="<?= $badgeClass ?>"><?= $status ?></span>
                        </td>
                        <?php
                    if (session()->get('level')==7){ ?>
                        <td>
                        <?php if ($value->status_kegiatan == 'Menunggu Persetujuan'): ?>
                            <a href="<?= base_url('home/setujui_kegiatan/'.$value->id_kegiatan) ?>" 
                            class="btn btn-success mt-1" 
                            onclick="return confirm('Setujui proposal ini dan ubah status jadi Berjalan?')">
                            <i class="material-symbols-rounded opacity-100">check_circle</i> Setujui
                            </a>
                            <a href="<?= base_url('home/tolakproposal/'.$value->id_kegiatan) ?>" 
                            class="btn btn-danger mt-1" 
                            onclick="return confirm('Yakin ingin menolak proposal ini?')">
                            <i class="material-symbols-rounded opacity-100">cancel</i> Tolak
                            </a>
                            <?php endif; ?>

                            <?php if ($value->status_kegiatan == 'Berjalan'): ?>
                                <a href="<?= base_url ('home/selesaikankegiatan/' .$value->id_kegiatan)?>" class="btn btn-info" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan kegiatan ini?')">
                                <i class="material-symbols-rounded">done_all</i> Selesaikan
                                </a>
                            <?php endif; ?>

                        
                        <!-- <a href="<?= base_url('home/editkegiatan/'.$value->id_kegiatan)?>" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengedit data ini?')">
                        <i class="material-symbols-rounded opacity-100">border_color</i>
                        </a> -->

                        </td>
                        <?php } ?>
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
  document.querySelectorAll('.selesai-btn').forEach(button => {
    button.addEventListener('click', function () {
      const idKegiatan = this.dataset.id;
      const judul = this.dataset.judul;
      const idProker = this.dataset.idproker;

      document.getElementById('id_kegiatan').value = idKegiatan;
      document.getElementById('id_proker').value = idProker;
      document.getElementById('judul_dokumentasi').value = judul;
    });
  });
</script>
<!-- 
<div id='calendar'></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: '/kegiatan/getKalender', // endpoint yang nanti kamu buat
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        eventClick: function(info) {
            alert('Kegiatan: ' + info.event.title);
        }
    });

    calendar.render();
});
</script> -->
