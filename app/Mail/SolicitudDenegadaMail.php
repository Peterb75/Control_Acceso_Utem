<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Persona\Personas;
use App\Models\SolicitudInvitado;

class SolicitudDenegadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $persona;
    public $solicitud;

    /**
     * Create a new message instance.
     */
    public function __construct($persona, $solicitud)
    {
        $this->persona = $persona;
        $this->solicitud = $solicitud;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Solicitud de invitación denegada')
                    ->view('mails.solicitud-denegada')
                    ->with([
                        'Nombres' => $this->persona->Nombres,
                        'ApellidoP' => $this->persona->ApellidoP,
                        'Motivo' => $this->solicitud->Motivo_Rechazo,
                        'Fecha' => $this->solicitud->FechaSolicitada,
                    ]);
    }
}
