<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailPedidos extends Mailable
{
    use Queueable, SerializesModels;

    public $pedido; // Variable pública que almacena la información del pedido que se enviará en el email

    /**
     * Constructor del email.
     * Se recibe el objeto $pedido que contiene toda la información del pedido para usarla en la plantilla.
     *
     * @param mixed $pedido Pedido que será enviado en el correo
     */
    public function __construct($pedido)
    {
        $this->pedido = $pedido;            // Asigna el pedido a la propiedad pública para que esté disponible en la vista del email
    }

    /**
     * Construye el mensaje del correo.
     * Define el asunto, la vista que se usará para el contenido del email y los datos que se pasarán a la vista.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuevo pedido recibido') // Asunto del correo
            ->view('emails.email-pedidos') // Vista Blade que contiene la plantilla del email
            ->with([ // Datos que se envían a la vista para mostrar en el email
                'pedido' => $this->pedido,
                'usuario' => $this->pedido->user, // Relación con el usuario que hizo el pedido
            ]);
    }
}
