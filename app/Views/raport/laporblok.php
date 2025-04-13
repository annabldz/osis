<!DOCTYPE html>
<html>
<head>
  <title>Hasil Nilai Blok</title>
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
    <h1 width="250%" style="text-align: center">SEKOLAH PERMATA HARAPAN</h1>
  </table>

  
<table class="table table-striped" border = "1" align="center" width = "600px">
    <thead>
      <tr>
        <th scope="col" width="5%">No</th>
        <th scope="col" width="20%">Mapel</th>
        <th scope="col" width="15%">Blok</th>  
        <th scope="col" width="20%">Guru</th>    
        <th scope="col" width="25%">Nilai Hasil Belajar</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($nilai as $key => $value) {
        ?>
        <tr>
          <td align="center"><?= $ms++ ?></td>
          <td align="center"><?= $value->nama_mapel ?></td>
          <td align="center"><?= $value->kode_blok ?></td>
          <td align="center"><?= $value->nama_guru ?></td>
          <td align="center"><?= $rata_rata ?></td>
      <?php } ?>

    </tr> 
    </tbody>
  </table>

</body>
</html>