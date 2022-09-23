<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        //
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->order->products = Order::orderWithProducts($this->order);
        $data = [
            'title' => 'Заказ №'.$this->order->id.' от '.$this->order->created_at.' отгружен.',
            'order' => $this->order,
            'orderstatus' => Order::orderstatus()
        ];
        return $this->subject($data['title'])
                    ->view('mail.order')->with($data);
    }
}
