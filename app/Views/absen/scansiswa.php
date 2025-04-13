<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>

<div id="scanner-container"></div>
<p id="scan-result"></p>

<script>
    Quagga.init({
        inputStream: {
            type : "LiveStream",
            constraints: {
                width: 480,
                height: 320,
                facingMode: "environment"
            },
            target: document.querySelector('#scanner-container')
        },
        decoder: {
            readers : ["code_128_reader", "qr_reader"]
        }
    }, function(err) {
        if (err) {
            console.error(err);
            return;
        }
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
        let qrData = result.codeResult.code;
        document.getElementById('scan-result').innerText = "QR Code: " + qrData;

        // Kirim ke controller untuk mencatat absensi
        fetch("<?= base_url('absen/scan_qr') ?>", {
            method: "POST",
            body: JSON.stringify({ qr_data: qrData }),
            headers: { "Content-Type": "application/json" }
        }).then(response => response.json())
          .then(data => alert(data.message));
    });
</script>
