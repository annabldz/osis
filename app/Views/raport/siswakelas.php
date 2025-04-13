<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Siswa</title>
</head>
<body>
    <h1>Filter Siswa Berdasarkan Kelas</h1>

    <!-- Form filter kelas -->
    <form method="POST" action="<?= base_url('home/siswakelas'); ?>">
        <label for="kelas_id">Pilih Kelas:</label>
        <select name="kelas_id" id="kelas_id">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach ($rombel as $k): ?>
                <option value="<?= $k->id_rombel; ?>"><?= $k->nama_rombel; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <!-- Menampilkan siswa yang sesuai dengan kelas -->
    <?php if (!empty($siswa)): ?>
        <h2>Siswa di Kelas <?= isset($kelas_id) ? $kelas_id : 'Semua Kelas'; ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($siswa as $s): ?>
                    <tr>
                        <td><?= $s->id_siswa; ?></td>
                        <td><?= $s->nama_siswa; ?></td>
                        <td><?= $s->id_rombel; ?></td> <!-- Menampilkan ID Kelas, bisa diubah sesuai kebutuhan -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada siswa yang ditemukan untuk kelas ini.</p>
    <?php endif; ?>
</body>
</html>
