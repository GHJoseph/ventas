<?php

namespace SisVentas\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarComprobante extends Mailable
{
    use Queueable, SerializesModels;
    public $persona;
    public $detalle;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($address, $subject, $persona, $detalle, $pdf)
    {
        $this->address = $address;
        $this->subject = $subject;
        $this->persona = $persona;
        $this->detalle = $detalle;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('correo.comprobante')
            ->to($this->address)
            ->subject($this->subject)
            ->attach($this->pdf);
        return $email;
    }
}
