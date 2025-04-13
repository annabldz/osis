<?php

namespace App\Libraries;

class Notification
{
    public function sendAppNotification($id_user, $pesan)
    {
        // Simpan notifikasi ke database
        $db = \Config\Database::connect();
        $db->table('notifikasi')->insert([
            'id_user' => $id_user,
            'pesan'   => $pesan,
            'status'  => 'unread',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function sendWhatsApp($nomor, $pesan)
    {
        // Integrasi API WhatsApp (contoh: Wablas, Twilio, dll.)
        // Misal: kirim ke API WhatsApp
    }

    public function sendTelegram($telegram_id, $pesan)
    {
        $token = "TOKEN_BOT_TELEGRAM";
        $url = "https://api.telegram.org/bot{$token}/sendMessage?chat_id={$telegram_id}&text=" . urlencode($pesan);
        file_get_contents($url);
    }

    public function sendEmail($email, $subject, $message)
    {
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject($subject);
        $emailService->setMessage($message);
        $emailService->send();
    }
}
