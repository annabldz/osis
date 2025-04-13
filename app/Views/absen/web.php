<div class="container-fluid px-2 px-md-4">
      <div class="card card-body mx-2 mx-md-2 mt-n6">
          <div class="row">
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                <h3 class="mb-0">Website Information</h6>
                </div>
                
                <div class="card-body p-3">
                <hr class="horizontal gray-light my-1">
                  <ul class="list-group">
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">Foto Web:</strong> &nbsp; <img src="<?= base_url('assets/img/'.$mey->foto);?>" class="w-45 border-radius-lg shadow-sm">
                        </li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm">
                        <strong class="text-dark">Nama Web:</strong> &nbsp; <?= $mey->nama ?>
                        </li>
                  </ul>
                  <div class="col d-flex align-items-end" class="form-control">
                      <a href="<?= base_url('absen/editweb/'.$mey->id)?>" class="btn btn-primary"
                      onclick="return confirm('Apakah Anda yakin ingin mengedit setting web?')">
                      <i class="material-symbols-rounded opacity-100">border_color</i> Edit Website</a>
                  </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>