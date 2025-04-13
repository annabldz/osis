<?php
require '../vendor/autoload.php'; // naik satu folder karena composer.json di root

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'yippiebluu@gmail.com';
    $mail->Password   = 'sqws lkfl nzpr ebab'; // app password dari Google
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Penerima
    $mail->setFrom('yippiebluu@gmail.com', 'Absensi App');
    $mail->addAddress('emailkamu@gmail.com', 'Nama Penerima'); // ganti

    // Konten
    $mail->isHTML(true);
    $mail->Subject = 'Tes Email dari PHPMailer';
    $mail->Body    = 'Halo! Ini adalah email test.';

    $mail->send();
    echo '✅ Email berhasil dikirim!';
} catch (Exception $e) {
    echo "❌ Email gagal dikirim. Error: {$mail->ErrorInfo}";
}
