<?php

namespace App\Notifications;

use App\Models\SuratPemberitahuan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuratPemberitahuanNotification extends Notification
{
    use Queueable;
    public $surat;

    public function __construct(SuratPemberitahuan $surat)
    {
        $this->surat = $surat;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Pemberitahuan Permohonan Kebutuhan Aplikasi Praktikum')
            ->line('Ada surat pemberitahuan baru dari Koordinator Lab Komputer.')
            ->action('Lihat Surat', url('/surat-pemberitahuan/'.$this->surat->id));
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Surat pemberitahuan: '.$this->surat->perihal,
            'id_surat' => $this->surat->id
        ];
    }
}
