<?php
header("Content-Type: image/png");

// Load font
$font = __DIR__ . '/arial.ttf'; // Pastikan ada font TTF di direktori yang sama

// Buat gambar kosong
$width = 700;
$height = 400;
$image = imagecreatetruecolor($width, $height);

// Warna
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$gray = imagecolorallocate($image, 200, 200, 200);
$blue = imagecolorallocate($image, 30, 144, 255);

// Isi background
imagefilledrectangle($image, 0, 0, $width, $height, $white);

// Tambahkan border
imagerectangle($image, 10, 10, $width - 10, $height - 10, $black);

// Tambahkan teks kartu pelajar
imagettftext($image, 20, 0, 30, 40, $blue, $font, "KARTU PELAJAR");

// Data siswa (simulasi, bisa diambil dari database)
$nama = "Nama: John Doe";
$nis = "NIS: 12345678";
$jenis_kelamin = "Jenis Kelamin: Laki-laki";
$alamat = "Alamat: Jl. Contoh No. 12";

// Tambahkan teks ke gambar
imagettftext($image, 15, 0, 30, 80, $black, $font, $nama);
imagettftext($image, 15, 0, 30, 110, $black, $font, $nis);
imagettftext($image, 15, 0, 30, 140, $black, $font, $jenis_kelamin);
imagettftext($image, 15, 0, 30, 170, $black, $font, $alamat);

// Load foto siswa
$foto_path = 'siswa_foto.png'; // Pastikan ada gambar siswa di path ini
if (file_exists($foto_path)) {
    $foto = imagecreatefrompng($foto_path);
    imagecopyresampled($image, $foto, 500, 50, 0, 0, 150, 150, imagesx($foto), imagesy($foto));
}

// Load QR Code
$qrcode_path = 'qrcode.png'; // Pastikan ada QR Code
if (file_exists($qrcode_path)) {
    $qrcode = imagecreatefrompng($qrcode_path);
    imagecopyresampled($image, $qrcode, 500, 220, 0, 0, 150, 150, imagesx($qrcode), imagesy($qrcode));
}

// Output gambar
imagepng($image);
imagedestroy($image);
