<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact)
    {
        //
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'title' => '[test mag]['.time().'] Сообщение от '.$this->contact->name.'. Тема: '.$this->contact->subject,
            'contact' => $this->contact
        ];
        return $this->subject($data['title'])
//            ->replyTo($this->contact->email)
            ->replyTo($this->contact->email, $this->contact->name)
            ->view('mail.contact')->with($data);
    }
}
