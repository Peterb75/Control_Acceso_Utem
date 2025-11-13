<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Persona\Personas;

class PersonaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $qrPath;
    public $persona;

    /**
     * Create a new message instance.
     *
     * @param string $qrPath
     * @param Personas $persona
     */
    public function __construct($qrPath, $persona)
    {
        $this->qrPath = $qrPath;
        $this->persona = $persona;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.personas')
                    ->attach($this->qrPath, [
                        'as' => 'qr_code.png',
                        'mime' => 'image/png',
                    ])
                    ->with([
                        'Nombres' => $this->persona->Nombres,
                        'ApellidoP' => $this->persona->ApellidoP,
                    ]);
    }
}
