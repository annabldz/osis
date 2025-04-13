<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Code</title>
    <style>
        /* Flexbox untuk pusatkan konten secara vertikal dan horizontal */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center; /* Pusatkan secara horizontal */
            align-items: center;     /* Pusatkan secara vertikal */
            font-family: Arial, sans-serif;
            position: relative;
        }
        
        .container {
            text-align: center;
        }

        video {
            width: 100%;
            max-width: 400px;
            transform: scaleX(-1); /* Flip video jika diperlukan */
        }

        /* Tombol Login di pojok kiri atas */
        .login-btn {
            position: fixed;
            top: 20px; /* Beri sedikit jarak dari atas */
            left: 25px;
            padding: 10px 20px;
            background-color: rgb(56, 56, 56);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: rgb(57, 58, 59);
        }

    </style>
</head>
<body>

    <!-- Tombol Login -->
    <button class="login-btn" onclick="window.location.href='<?= base_url('/absen/login') ?>'">Login</button>
        
    <div class="container mt-3">
        <h3>Scan QR Code untuk Absensi Guru</h3>
        <video id="qr-video" playsinline></video>
    </div>

    <script src="<?= base_url('assets/js/qr-scanner.legacy.min.js') ?>"></script>
    <script>
    console.log("Memuat QR Scanner...");

    const video = document.getElementById('qr-video');
    if (!video) {
        console.error("Elemen video tidak ditemukan!");
    }

    // Inisialisasi QR Scanner
    const scanner = new QrScanner(video, result => {
        console.log("Full Scan Result:", result);

        // Ambil data QR code
        const qrData = result?.data || result;
        console.log("QR Code Data:", qrData);

        // Kirim hasil scan ke backend pakai AJAX
        fetch('<?= base_url('absen/scanguru') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ qr_data: qrData }) // Kirim QR Code ke backend
        })
        .then(response => response.json())
        .then(data => {
            console.log("✅ Respon dari server:", data);
            alert(data.message);
        })
        .catch(error => console.error("❌ Fetch Error:", error));

    }, { returnDetailedScanResult: true });

    // Pastikan kamera aktif    
    scanner.start().then(() => {
        console.log("QR Scanner telah dimulai!");
    }).catch(err => {
        console.error("Gagal mengakses kamera:", err);
    });

    </script>

</body>
</html>
