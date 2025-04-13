<!DOCTYPE html>
<html>
<head>
  <title>Hasil Absensi</title>
  <style type="text/css">
    table,
    th,
    td{
      
      border-collapse: collapse;
    }
  </style>
  
</head>
<body>
  <table>
    <h10 width="250%" style="text-align: center">LAPORAN ABSENSI SISWA</h10>
  </table>

  
<table class="table table-striped" border = "1" align="center" width = "600px">
    <thead>
      <tr>
        <th scope="col" width="5%">No</th>
        <th scope="col" width="20%">Nama Siswa</th>
        <th scope="col" width="15%">Kelas</th>  
        <th scope="col" width="20%">Tanggal Absensi</th>    
        <th scope="col" width="25%">Status</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $ms = 1;
      foreach ($anjas as $key => $value) {
        ?>
        <tr>
          <td align="center"><?= $ms++ ?></td>
          <td align="center"><?= $value->nama_siswa ?></td>
          <td align="center"><?= $value->nama_kelas ?></td>
          <td align="center"><?= $value->tanggal ?></td>
          <td align="center"><?= $value->status ?></td>
      <?php } ?>

    </tr> 
    </tbody>
  </table>


</body>
</html>
<script>
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="laporan_siswa.xlsx"');
    header('Cache-Control: max-age=0');
  </script>