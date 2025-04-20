<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #444; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>LPJ Kegiatan: <?= $kegiatan['judul_kegiatan'] ?></h3>
    <table>
        <thead>
            <tr>
                <th>Pemasukan (Rp)</th>
                <th>Sumber</th>
                <th>Pengeluaran (Rp)</th>
                <th>Penggunaan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pemasukan = array_filter($items, fn($i) => $i['tipe'] == 'masuk');
            $pengeluaran = array_filter($items, fn($i) => $i['tipe'] == 'keluar');
            $maxRows = max(count($pemasukan), count($pengeluaran));
            for ($i = 0; $i < $maxRows; $i++):
                $in = $pemasukan[$i] ?? null;
                $out = $pengeluaran[$i] ?? null;
            ?>
            <tr>
                <td><?= $in ? 'Rp' . number_format($in['jumlah'], 0, ',', '.') : '' ?></td>
                <td><?= $in['sumber'] ?? '' ?></td>
                <td><?= $out ? 'Rp' . number_format($out['jumlah'], 0, ',', '.') : '' ?></td>
                <td><?= $out['penggunaan'] ?? '' ?></td>
            </tr>
            <?php endfor; ?>
        </tbody>
    </table>
</body>
</html>
