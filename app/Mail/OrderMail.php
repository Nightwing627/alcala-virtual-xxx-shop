<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $pdf;
    protected $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $user, $pdf)
    {
        $this->order = $order;
        $this->pdf = $pdf;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pedido')->markdown('emails.pedido')->with(['order'=> $this->order, 'user' => $this->user])
                ->attachData($this->pdf, "Recibo.pdf",[
                        'mime' => 'application/pdf'
                    ]);
    }
}
