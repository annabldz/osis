<form method="get" action="">
    <label for="bulan">Filter Bulan:</label>
    <input type="month" name="bulan" id="bulan" value="<?= $bulan ?>">
    <button type="submit" class="btn btn-primary">Filter</button>
    <a href="<?= base_url('home/keuangan') ?>" class="btn btn-secondary">Reset</a>
</form>
<?php 
if (session()->get('level')==1 || session()->get('level')== 3 )  { ?>
<a href="<?= base_url('home/inputkeuangan') ?>" class="btn btn-warning">+ Tambah Data</a>
<?php } ?>

<a href="<?= base_url('home/exportExcel?bulan=' . $bulan) ?>" class="btn btn-success">Export Excel</a>
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
                <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                
                <td>
                <a href="<?= base_url('img/'.$row['nota']);?>">
                    <img src="<?= base_url('img/'.$row['nota']); ?>" width="45px" >
                </td>
                </tr>
        <?php endforeach ?>
    </tbody>
</table>
