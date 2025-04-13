<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\M_absensi;
use App\Models\M_user;
use App\Libraries\Notification;

class ReminderAbsen extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'reminder:absen';
    protected $description = 'Kirim reminder absen ke pengguna yang belum absen';

    public function run(array $params)
    {
        $modelAbsensi = new M_absensi();
        $modelUser = new M_user();
        $notif = new Notification(); // Library untuk kirim notifikasi

        $jam_sekarang = date('H:i');
        $tanggal = date('Y-m-d');
        CLI::write('Waktu saat ini: ' . $jam_sekarang, 'blue');
        // Cek jam pengiriman reminder
        if ($jam_sekarang === '12:00' || $jam_sekarang === '15:00') {
            $belumAbsen = $modelAbsensi->getBelumAbsen($tanggal);

            foreach ($belumAbsen as $user) {
                $pesan = "Hai, {$user->nama}! Jangan lupa absen hari ini sebelum pukul 16:00.";
                
                // Kirim notifikasi ke aplikasi
                $notif->sendAppNotification($user->id_user, $pesan);

                // Kirim ke WhatsApp / Telegram
                if (!empty($user->no_hp)) {
                    $notif->sendWhatsApp($user->no_hp, $pesan);
                }

                // if (!empty($user->telegram_id)) {
                //     $notif->sendTelegram($user->telegram_id, $pesan);
                // }

                // Kirim email
                if (!empty($user->email)) {
                    $notif->sendEmail($user->email, "Reminder Absen", $pesan);
                }
            }

            CLI::write('Reminder absen telah dikirim!', 'green');
        } else {
            CLI::write('Bukan waktu pengiriman reminder.', 'yellow');
        }
    }
}
