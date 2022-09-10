<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    private $name;
    private $email;
    private $phone;
    private $subject;
    private $message;

    public function setData($send_object)
    {
        $this->name = $send_object->name;
        $this->email = $send_object->email;
        $this->phone = $send_object->phone;
        $this->subject = $send_object->subject;
        $this->message = $send_object->message;
    }

    public function validForm () {
        if(strlen($this->name) < 3)
            return "name is too shot";
        elseif (strlen($this->email) < 3)
            return "email is too shot";
        elseif (strlen($this->phone) < 6)
            return "phone is too shot";
        elseif (strlen($this->subject) < 3)
            return "subject is too shot";
        elseif (strlen($this->message) < 10)
            return "message is too shot";
        else return "ok";
    }
    public function mail () {
        $to = "james50@mail.ru";
        $message = "name: $this->name, phone: $this->phone, messsage: $this->message";
        $subject = "=7utf-8?B?".base64_encode("[testmaglaravel] $this->subject")."?=";
        $headers = "From: $this->email\r\nReply-to: $this->email\r\nContent-type: text-html; charset=utf-8\r\n";
        $success = mail($to, $subject, $message, $headers);
        return ($success ? "Сообщение отправлено": "Сообщение не отправлено");
    }
}
