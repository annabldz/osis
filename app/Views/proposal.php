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
                    <h6 class="text-white text-capitalize ps-3">PROPOSAL OSIS</h6>
                </div>
                </div>
                <div class="card-body px-3 pb-2">
                       <div class="row">
                          <?php foreach ($anjas as $key => $value) { ?>
                          <div class="col-md-4">
                              <div class="card">
                            
                                  <div class="card-body">
                                      <h5 class="card-title"> <?= $value->judul_kegiatan ?></h5>
                                      <p class="card-text">Bagian Proker: <?= $value->judul_proker ?> </p>
                                      <p class="card-text"><?= $value->deskripsi ?></p>

                                      <a href="  <?= base_url('uploads/proposal/'.$value->proposal_file);?>" class="btn btn-danger"><i class="material-symbols-rounded opacity-100">open_with</i>Lihat</a>
                                      <!-- <a href="<?= base_url('home/hapusproduk/'.$value->id_produk)?>" class="btn btn-danger"
                                      onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a> -->
                                  </div>
                              </div>
                          </div>
                          <?php } ?>
                      </div>
                  </div>

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
