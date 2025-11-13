<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class QRCodeNotification extends Notification
{
    use Queueable;

    protected $codigoIdentificacion;
    protected $qrPath;

    public function __construct($codigoIdentificacion, $qrPath)
    {
        $this->codigoIdentificacion = $codigoIdentificacion;
        $this->qrPath = $qrPath;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Su Código QR de Invitación')
            ->line('Por favor, encuentre su código QR de invitación adjunto a este correo.')
            ->line('Código de Identificación: ' . $this->codigoIdentificacion)
            ->attach($this->qrPath);
    }

    public function toArray($notifiable)
    {
        return [
            'codigoIdentificacion' => $this->codigoIdentificacion,
        ];
    }
}
