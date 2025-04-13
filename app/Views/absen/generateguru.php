
<div class="container mt-2">
    <h3>QR ABSENSI</h3>

    <div class="row g-3">
        <div class="col-12">
            <div class="card my-2">
                <div class="card-body px-3 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>QR Code</th>
                                    <th>Nama Guru</th>
                                    <th>NIK</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($anjas): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('img/'.$anjas->code);?>">
                                        <img src="<?= base_url('img/' . $anjas->code); ?>" width="100px">
                                    </td>
                                    <td><?= $anjas->nama_guru ?></td>
                                    <td><?= $anjas->nik ?></td>

                                </tr>
                                <?php else: ?>
                                <tr>
                                    <td colspan="3">Data tidak ditemukan.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
