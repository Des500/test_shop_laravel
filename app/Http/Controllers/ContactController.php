<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    //

    public function index()
    {
        $send_object = new \stdClass();
        $send_object->name = '';
        $send_object->email = '';
        $send_object->phone = '';
        $send_object->subject = '';
        $send_object->message = '';

        $data = [
            'form' => $send_object,
            'message' => ''
        ];
        if (!Auth::guest()) {
            $data['form']->name = Auth::user()->name;
            $data['form']->email = Auth::user()->email;
        }

        return view('contact.index')->with($data);
    }

    public function sendmessage (Request $request) {
            $send_object = new \stdClass();
            $send_object->name = $request->input('name');
            $send_object->email = $request->input('email');
            $send_object->phone = $request->input('phone');
            $send_object->subject = $request->input('subject');
            $send_object->message = $request->input('message');

            $data['form'] = $send_object;
            $mail = new Contact();
            $mail->setData($send_object);
            $isValid = $mail->validForm();
            if($isValid==='ok') {
                $messagemail = new MailController();
                $messagemail->sendContactMessage($send_object);
                $data['message'] = 'Сообщение отправлено';
                $data['success'] = $data['message'];
            }
            else {
                $data['message'] = $isValid;
            }
        return view('contact.index')->with($data);
    }

    public function about()
    {
        return view('contact.about');
    }
}
