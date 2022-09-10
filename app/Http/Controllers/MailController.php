<?php

namespace App\Http\Controllers;

use App\Mail\MessageMail;
use App\Mail\OrderMail;
use App\Mail\PaymentMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function send () {
        $mail_status = Mail::send(['html' => 'mail.mail'], ['name' => 'TestMag'], function ($message) {
            $message->to('james50@mail.ru', 'Test Magazin')->subject('Test message');
            $message->from('info@w101.ru', 'Test Magazin');
        });
        echo 'mail status: '.$mail_status;
        print_r($mail_status);
        $data = [
            'title' => 'test mail message',
            'text' => 'test message'
        ];
        return view('mail.mail')->with($data);
    }
    public function sendOrder ($order) {
        $user = User::find($order->user_id);
        return Mail::to($user->email)->send(new OrderMail($order));
    }

    public function sendContactMessage ($Contact) {
        $user = User::find(1);
        return Mail::to($user->email, $user->name)->send(new MessageMail($Contact));
    }

    public function sendPaymentNotif ($transaction) {
        $order = Order::find($transaction->order_id);
        $user = User::find($order->user_id);
        $transaction->order = $order;
        $transaction->user = $user;
        return Mail::to($user->email)->send(new PaymentMail($transaction));
    }
}
