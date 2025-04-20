<form method="get" action="<?= base_url('home/keuangan') ?>" class="row">
    <!-- Filter Bulan -->
    <div class="col-md-2">
        <label for="bulan_awal">Bulan Awal:</label>
        <input type="month" name="bulan_awal" id="bulan_awal" value="<?= $bulan_awal ?? '' ?>" class="form-control">
    </div>
    <div class="col-md-2">
        <label for="bulan_akhir">Bulan Akhir:</label>
        <input type="month" name="bulan_akhir" id="bulan_akhir" value="<?= $bulan_akhir ?? '' ?>" class="form-control">
    </div>

    <!-- Filter Kegiatan -->
    <div class="col-md-2">
        <label for="id_kegiatan">Kegiatan:</label>
        <select name="id_kegiatan" id="id_kegiatan" class="form-select">
            <option value="">-- Semua Kegiatan --</option>
            <?php foreach ($kegiatan as $k): ?>
                <option value="<?= $k['id_kegiatan'] ?>" <?= ($id_kegiatan == $k['id_kegiatan']) ? 'selected' : '' ?>>
                    <?= $k['judul_kegiatan'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Tombol Filter -->
    <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>

    <!-- Tombol Reset -->
    <div class="col-md-2 d-flex align-items-end">
        <a href="<?= base_url('home/keuangan') ?>" class="btn btn-secondary w-100">Reset</a>
    </div>
            </form>
            <a href="<?= base_url('home/inputkeuangan') ?>" class="btn btn-warning">+ Tambah Data</a>

    <!-- Tombol Export Excel -->
    <div class="col-md-2 d-flex align-items-end">
        <a href="<?= base_url('home/exportExcel?bulan_awal=' . urlencode($bulan_awal) . '&bulan_akhir=' . urlencode($bulan_akhir) . '&id_kegiatan=' . urlencode($id_kegiatan)) ?>" class="btn btn-success w-100">Export Excel</a>
    </div>



<div class="alert alert-light mt-3">
    <strong>Total Pemasukan:</strong> Rp<?= number_format($totalPemasukan, 0, ',', '.') ?><br>
    <strong>Total Pengeluaran:</strong> Rp<?= number_format($totalPengeluaran, 0, ',', '.') ?><br>
    <strong>Total Kas OSIS:</strong> <span class="fw-bold">Rp<?= number_format($totalKas, 0, ',', '.') ?></span>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Tipe</th>
            <th>Jumlah</th>
            <th>Bukti Nota</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($keuangan as $row): ?>
            <tr>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['keterangan'] ?></td>
                <td><?= $row['tipe'] ?></td>
                <td>Rp<?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                <td>
                    <a href="<?= base_url('img/' . $row['nota']) ?>" target="_blank">
                        <img src="<?= base_url('img/' . $row['nota']) ?>" width="45px">
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
