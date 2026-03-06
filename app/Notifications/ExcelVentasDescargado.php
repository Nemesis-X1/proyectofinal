<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExcelVentasDescargado extends Notification
{
    protected string $filename;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Reporte de ventas listo para descargar',
            'url' => route('export.excel-ventas-download', ['filename' => $this->filename]),
            'icon' => 'fa-file-excel'
        ];
    }
}
