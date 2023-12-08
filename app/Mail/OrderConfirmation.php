<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $cartItems;

    public function __construct($user, $cartItems, $total)
{
    $this->user = $user;
    $this->cartItems = $cartItems;
    $this->total = $total;
}

public function build()
{
    return $this->view('emails.orderconfirmation')
                ->with([
                    'user' => $this->user,
                    'cartItems' => $this->cartItems,
                    'total' => $this->total
                ]);
}

}
