<!DOCTYPE html>

<title>Input Barang</title>
<link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css');?>">     
<script src="<?= base_url('js/bootstrap.bundle.min.js'); ?>"></script>

<body>
<div class="container mt-3">    
<h3>Tambah Data Barang</h3>
<form action="" method="POST">
    <table>
        <tr>
            <td width="120">ID Barang</td>
            <td><input type="number" class="form-control"></td>
        </tr>
        <tr>
            <td>Kategori Barang</td>
            <td><select>
                <option>Pakaian Wanita</option>
                <option>Pakaian Pria</option>
                <option>Pakaian Bayi</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Nama Barang</td>
            <td><input type="text" class="form-control" size="20"></td>
        </tr>
        <tr>
            <td>
                <input type="submit" class="form-control" value="Simpan">
                <input type="reset" class="form-control" value="Reset">
                <input type="button" class="form-control" value="Kembali">
            </td>
        </tr>
    </table>
</form>
</body>