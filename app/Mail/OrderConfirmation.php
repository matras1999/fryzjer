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

    public function __construct($user, $cartItems)
    {
        $this->user = $user;
        $this->cartItems = $cartItems;
    }

    public function build()
{
    $total = 0;
    foreach ($this->cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    return $this->view('emails.orderconfirmation')
                ->with([
                    'cartItems' => $this->cartItems,
                    'total' => $total,
                ]);
}

}
