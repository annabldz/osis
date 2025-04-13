<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LAPORAN KEUANGAN ELYSIUM HOTEL</title>
  <style type="text/css">
  table,
  th,
  td {
    border-collapse: collapse;
    font-family: sans-serif;
    padding: 5px;
  }
  </style>
</head>
<body>

  <!-- Header -->
  <table>
    <tr>
      <td width="100px">
        <img src="<?= base_url('img/elysium-logo.png'); ?>" width="100px">
      </td>
      <td width="250%">
        <h3>ELYSIUM HOTEL</h3>
        <h4>Laporan Keuangan</h4>
      </td>
    </tr>
  </table>

  <!-- Table -->
  <table border="1" id="tabelnota">
    <thead>
      <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Total</th>
        <th>Bayar</th>
        <th>Kembalian</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $ms = 1;
      $totalIncome = 0; // Initialize total income variable
      foreach ($chelsica as $key => $value) {
        $totalIncome += $value->total; // Add each total to the sum
      ?>
        <tr>
          <td align="center"><?= $ms++ ?></td>
          <td align="center"><?= $value->tanggal ?></td>
          <td align="center"><?= number_format($value->total, 2) ?></td>
          <td align="center"><?= number_format($value->bayar, 2) ?></td>
          <td align="center"><?= number_format($value->kembali, 2) ?></td>
        </tr>
      <?php
      }
      ?>
    </tbody>
    <!-- Footer Row for Total Income -->
    <tfoot>
      <tr>
        <td colspan="2" align="center"><strong>Total Income</strong></td>
        <td align="center"><strong><?= number_format($totalIncome, 2) ?></strong></td>
        <td colspan="2"></td>
      </tr>
    </tfoot>
  </table>

  <script>
    window.onload = () => {
      const table = document.getElementById('tabelnota');
      exportTable(table, 'laporan_keuangan.xls');
    };

    function exportTable(table, filename) {
      const tableHTML = encodeURIComponent(table.outerHTML);
      const downloadLink = document.createElement('a');

      downloadLink.href = `data:application/vnd.ms-excel,${tableHTML}`;
      downloadLink.download = filename;
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
      window.close();
    }
  </script>
</body>
</html>
