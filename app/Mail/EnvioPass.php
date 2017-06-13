<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnvioPass extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $nombre;
    protected $apellido;
    protected $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $nombre, $apellido1, $password)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->apellido1 = $apellido1;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.pass')
                    ->with([
                        'email' => $this->email,
                        'nombre' => $this->nombre,
                        'apellido1' => $this->apellido1,
                        'password' => $this->password,
                    ])
                    ->subject('Bienvenido a LaBiblioteca');
    }
}
