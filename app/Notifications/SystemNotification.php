<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;

    // Menangkap data yang dikirim dari Controller
    public function __construct($title, $message, $url)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
    }

    // Kita simpan notifikasinya di Database
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Format data yang masuk ke database
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}