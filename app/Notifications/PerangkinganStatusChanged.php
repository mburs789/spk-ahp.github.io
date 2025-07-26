<?php

namespace App\Notifications;

use App\Models\Perangkingan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PerangkinganStatusChanged extends Notification
{
    use Queueable;

    protected $perangkingan;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Perangkingan  $perangkingan
     * @return void
     */
    public function __construct(Perangkingan $perangkingan)
    {
        $this->perangkingan = $perangkingan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];  // Mengirimkan email dan menyimpan ke database
    }

    /**
     * Get the mail representation of the notification.
     */
// app/Notifications/PerangkinganStatusChanged.php

public function toMail(object $notifiable): MailMessage
{
    $status = $this->perangkingan->status;
    $message = '';

    // Sesuaikan pesan berdasarkan status
    if ($status == 'accepted') {
        $message = 'Status penilaian karyawan ' . $this->perangkingan->karyawan->nama_karyawan . ' telah diterima oleh manajer.';
    } elseif ($status == 'rejected') {
        $message = 'Status penilaian karyawan ' . $this->perangkingan->karyawan->nama_karyawan . ' telah ditolak oleh manajer.';
    }

    // Jika status tidak sesuai, kirimkan pesan default
    if ($message === '') {
        $message = 'Status penilaian karyawan ' . $this->perangkingan->karyawan->nama_karyawan . ' telah diperbarui.';
    }

    return (new MailMessage)
        ->line($message)
        ->action('Lihat Perankingan', url('/perangkingan/' . $this->perangkingan->id))
        ->line('Status baru: ' . $this->perangkingan->status);
}

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->perangkingan->status;
        $message = '';
    
        // Sesuaikan pesan berdasarkan status
        if ($status == 'accepted') {
            $message = 'Status penilaian karyawan ' . $this->perangkingan->karyawan->nama_karyawan . ' telah diterima oleh manajer.';
        } elseif ($status == 'rejected') {
            $message = 'Status penilaian karyawan ' . $this->perangkingan->karyawan->nama_karyawan . ' telah ditolak oleh manajer.';
        }
    
        return [
            'message' => $message, // Pastikan kunci 'message' ada
            'perangkingan_id' => $this->perangkingan->id,
            'status' => $this->perangkingan->status,
        ];
    }
    
}
