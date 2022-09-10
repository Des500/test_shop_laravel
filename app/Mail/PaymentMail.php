<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        //
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'title' => 'Оплата заказа № '.$this->transaction->order_id.' от '.$this->transaction->order->created_at,
            'transaction' => $this->transaction
        ];
        return $this->subject($data['title'])
            ->view('mail.payment')->with($data);
    }
}
