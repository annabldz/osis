 <main id="main" class="main">

    <section class="section">
      <div class="row">
          <div class="card">
            <div class="card-body">
              <div class="col-lg-500 col-md-11 col-8 mx-auto">
              <h3 class="card-title">Edit Setting Web</h5>

    <form action="/absen/saveweb" method="POST" enctype="multipart/form-data">
        <div class="input-group input-group-static mb-4">
        <img src="<?= base_url('assets/img/'.$mey->foto);?>" width="130"  alt="Produk">    
        <input type="file" class="form-control" name="fotoweb" accept="img/"  value="<?= $mey->foto ?>" onchange="previewLogo(event)" required>
        </div>
        <div class="input-group input-group-static mb-4">
          <label>Nama Web:</label>
          <input type="text" class="form-control" id="namaweb" name="namaweb" value="<?= $mey->nama ?>">
        </div>
        <tr>
          <td>
            <input type="hidden" value="<?= $mey->id ?>" name="id">
            <button type="submit" class="btn btn-dark" onclick="return confirm('Apakah Anda yakin ingin menyimpan perubahan ini?')">Simpan</button>
            
          </td>
        </tr>

    </form>
    <!-- <script type="text/javascript">
      document.getElementById("image").onchange = function(){
        document.getElementById('form').submit();
      }
    </script> -->

    <script>
function previewLogo(event) {
    const image = document.getElementById('preview-logo');
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            image.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
}
</script>
