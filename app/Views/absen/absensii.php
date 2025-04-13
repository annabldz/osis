<head>
<script src="https://unpkg.com/html5-qrcode"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/instascan/1.0.0/instascan.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

</head>

<div class="container mt-3">
    <h3>Scan QR Code untuk Absensi</h3>

    <video id="preview" style="width: 100%; max-width: 400px;"></video>

    <form action="<?= base_url('absen/scanQR') ?>" method="post">
        <input type="hidden" name="nis" id="nis">
        <input type="text" id="result" placeholder="Hasil scan akan muncul di sini">
        </form>
</div>
<script>
navigator.mediaDevices.enumerateDevices().then(devices => {
    let videoDevices = devices.filter(device => device.kind === "videoinput");

    if (videoDevices.length > 0) {
        let selectedDeviceId = videoDevices[0].deviceId; // Gunakan kamera pertama
        startScanner(selectedDeviceId);
    } else {
        console.log("Tidak ada kamera yang terdeteksi.");
    }
}).catch(err => console.log(err));

function startScanner(deviceId) {
    let constraints = { video: { deviceId: { exact: deviceId } } };

    navigator.mediaDevices.getUserMedia(constraints).then(stream => {
        document.getElementById("preview").srcObject = stream;
    }).catch(err => console.log("Error: ", err));
}
</script>


<div class="main-panel">
    <div class="content">
       <div class="container-fluid">
          <div class="row mx-auto">
             <div class="col-lg-3 col-xl-4">
                <div class="card">
                   <div class="card-body">
                      <h3 class="mt-2"><b>Tips</b></h3>
                      <ul class="pl-3">
                         <li>Tunjukkan qr code sampai terlihat jelas di kamera</li>
                         <li>Posisikan qr code tidak terlalu jauh maupun terlalu dekat</li>
                      </ul>
                   </div>
                </div>
             </div>
             <div class="col-lg-6 col-xl-4">
                <div class="card">
                   <div class="col-10 mx-auto card-header card-header-primary">
                      <div class="row">
                         <div class="col">
                            <h4 class="card-title"><b>Absen <?= $waktu; ?></b></h4>
                            <p class="card-category">Silahkan tunjukkan QR Code anda</p>
                         </div>
                         <div class="col-md-auto">
                            <a href="<?= base_url("scan/$oppBtn"); ?>" class="btn btn-<?= $oppBtn == 'masuk' ? 'success' : 'warning'; ?>">
                               Absen <?= $oppBtn; ?>
                            </a>
                         </div>
                      </div>
                   </div>
                   <div class="card-body my-auto px-5">
                      <h4 class="d-inline">Pilih kamera</h4>

                      <select id="pilihKamera" class="custom-select w-50 ml-2" aria-label="Default select example" style="height: 35px;">
                         <option selected>Select camera devices</option>
                      </select>

                      <br>

                      <div class="row">
                         <div class="col-sm-12 mx-auto">
                            <div class="previewParent">
                               <div class="text-center">
                                  <h4 class="d-none w-100" id="searching"><b>Mencari...</b></h4>
                               </div>
                               <video id="previewKamera"></video>
                            </div>
                         </div>
                      </div>
                      <div id="hasilScan"></div>
                      <br>
                   </div>
                </div>
             </div>
             <div class="col-lg-3 col-xl-4">
                <div class="card">
                   <div class="card-body">
                      <h3 class="mt-2"><b>Penggunaan</b></h3>
                      <ul class="pl-3">
                         <li>Jika berhasil scan maka akan muncul data siswa/guru dibawah preview kamera</li>
                         <li>Klik tombol <b><span class="text-success">Absen masuk</span> / <span class="text-warning">Absen pulang</span></b> untuk mengubah waktu absensi</li>
                         <li>Untuk melihat data absensi, klik tombol <span class="text-primary"><i class="material-icons" style="font-size: 16px;">dashboard</i> Dashboard Petugas</span></li>
                         <li>Untuk mengakses halaman petugas anda harus login terlebih dahulu</li>
                      </ul>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

 