<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Guru</title>
    <style>
        table, th, td {
            border-collapse: collapse;
            text-align: center;
        }
        th {
            background-color: #ddd;
            font-weight: bold;
        }
        table {
            width: 100%;
            border: 1px solid black;
        }
        td, th {
            padding: 8px;
            border: 1px solid black;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>LAPORAN ABSENSI GURU</h1>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Guru</th>
            <th width="20%">NIK</th>
            <th width="20%">Tanggal Absensi</th>
            <th width="25%">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($anjas)): ?>
            <?php $ms = 1; ?>
            <?php foreach ($anjas as $value): ?>
                <tr>
                    <td><?= $ms++ ?></td>
                    <td><?= $value->nama_guru ?></td>
                    <td><?= $value->nik ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->status ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Tidak ada data absensi</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
