<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Paymentsystem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'getnotification',
            ]]);
    }

    public function paymentorder ($id) {
        $order = Order::find($id);
        $paymentsystem = (array)json_decode(Paymentsystem::find(4)->sendfields);
        $paycontent = new \stdClass();
        foreach ($paymentsystem as $tag => $item)
            $paycontent->{$tag} = $item;
        $paycontent->formcomment = 'Заказ '.$order->id.' от '. $order->created_at;
        $paycontent->short_dest = 'Заказ '.$order->id.' от '. $order->created_at;
        $paycontent->label = $order->id;
        $paycontent->targets = $order->user_id.'_order_'.$order->id;
        $paycontent->sum = $order->summa;
        $paycontent->successURL = route('succesurl', ['id' => $order->id]);

        $data = [
            'paycontent' => $paycontent,
            'title' => 'Оплата заказа № '.$order->id.' от '. $order->created_at
        ];
        return view('payment.yoomoney')->with($data);
    }

    public function newpaymentsystem () {
        $paymentsystem = new Paymentsystem();
        $sendfields = [
            'receiver' => '41001143264362',                 //name => value
            'need_fio' => 'false',
            'need_email' => 'false',
            'need_phone' => 'false',
            'need_address' => 'false',
        ];
        $sendfieldsjson=json_encode($sendfields);
        print($sendfieldsjson);
        $paymentsystem->name = 'yoomoney';
        $paymentsystem->sendfields = $sendfieldsjson;
        $paymentsystem->receivefields = '';
        $paymentsystem->save();
    }

    public function getnotification (Request $request) {

        $order_id = (int)$request->input('label');
        $summa_order = (float)$request->input('withdraw_amount');
        $amount = (float)$request->input('amount');
        $commission = $summa_order-$amount;

        $transaction = new Transaction();
        $transaction->order_id = $request->input('label');
        $transaction->payment_system = 'yoomoney';
        $transaction->payment_method = $request->input('notification_type');
        $transaction->transction_id = $request->input('operation_id');
        $transaction->summa_order = $summa_order;
        $transaction->commission = $commission;
        $transaction->amount = $amount;
        $transaction->post_content = $request;
        $transaction->save();

        $order = Order::find($order_id);
        if($order->summa == $summa_order) {
            $order->order_status = 'paid';
            $order->save();
        }
        $paymentmail = new MailController();
        $paymentmail->sendPaymentNotif($transaction);

        die('HTTP/1.1 200 OK');
    }

    public function succesurl ($order_id) {
//        echo 'все оплачено '.$order_id;
        return redirect(route('showorder', ['id' => $order_id]).'?'.time())->with(['success' => 'Заказ успешно оплачен']);
    }
}


////        ответ юмани
//$otvet = '
//POST /public/getnotification HTTP/1.1
//Accept:            */*
//Content-Length:    394
//Content-Type:      application/x-www-form-urlencoded
//Cookie:            XSRF-TOKEN=eyJpdiI6InhIUmVpU204R0tZN21aVndwNC9neHc9PSIsInZhbHVlIjoiY040MXlzM0ppZjY3SEtSR0JIcStsVkd0L1crcVZHcUg0R2ZSWnJOazhKOEV6SWVWNmxTWjVnOFh1T0dTcFZvRHp3dDdDUkhoellIZWxXS2pSQjJFZnZHb0JoMzdFNEhzTDBHNnBMNnlrM2ppQVRaMzJMdTgyOHkvNXRrT3FPUWIiLCJtYWMiOiIyZmI4MDcyODExNjFlZmJmNDY4M2I4MGY5MmFjYzg3ODZjMDQzMTU0NmEzZDJhMzBjZmE2MDYxYzBhYWYzNzU0IiwidGFnIjoiIn0%3D; testmaglaravel_session=eyJpdiI6ImszYmNQZ0xjWDY4RXBzU1Y5NWVTTWc9PSIsInZhbHVlIjoiMzNESzh0MWZnWCtLZzRWOHFLazl6UWwzWkd3Tml4a2Npc0pMWlZKekdPbVY5enFSNG5INW91eTZORFFxT1FsV0xMTXJORitGN2s1MnpKNTZNZnNwaGlHNVNXY1NmUlkvRWo0MTVkMjdubVlUbGoyVVJQdFZVa3hYbWNQYzJwZXEiLCJtYWMiOiI2NzkyYWJmMTAwYzYxODBkYzU2ZTk4ODZmOWE2YzE4YmM1NDQwMDgwM2I4YjYxNWE4MzVhMzI4ZDM5Njk5NjYwIiwidGFnIjoiIn0%3D
//Host:              des50.myftp.org
//User-Agent:        AHC/2.1
//X-Forwarded-Proto: https
//Cookie: XSRF-TOKEN=VbPNhDY8Dz0hWuXgj6s8azHmp8uwt2vqoO5rkSlX; testmaglaravel_session=asmYbJPrvA86ZYxu3KfvDUY9jJwbsXjZ0kLapwWs
//
//notification_type=card-incoming&zip=&bill_id=&amount=9.70&firstname=&codepro=false&withdraw_amount=10.00&city=&unaccepted=false&label=7&building=&lastname=&datetime=2022-09-06T22%3A23%3A14Z&suite=&sender=&phone=&sha1_hash=6f7c9d805551449f0384589b6fd72c8bbb25275c&street=&flat=&fathersname=&operation_label=2aa9dbfd-0011-5000-a000-112d64aece00&operation_id=715818194137004004&currency=643&email=
//';
//        POST /public/getnotification HTTP/1.1
//Accept:            */*
//Content-Length:    394
//Content-Type:      application/x-www-form-urlencoded
//Cookie:            XSRF-TOKEN=eyJpdiI6InhIUmVpU204R0tZN21aVndwNC9neHc9PSIsInZhbHVlIjoiY040MXlzM0ppZjY3SEtSR0JIcStsVkd0L1crcVZHcUg0R2ZSWnJOazhKOEV6SWVWNmxTWjVnOFh1T0dTcFZvRHp3dDdDUkhoellIZWxXS2pSQjJFZnZHb0JoMzdFNEhzTDBHNnBMNnlrM2ppQVRaMzJMdTgyOHkvNXRrT3FPUWIiLCJtYWMiOiIyZmI4MDcyODExNjFlZmJmNDY4M2I4MGY5MmFjYzg3ODZjMDQzMTU0NmEzZDJhMzBjZmE2MDYxYzBhYWYzNzU0IiwidGFnIjoiIn0%3D; testmaglaravel_session=eyJpdiI6ImszYmNQZ0xjWDY4RXBzU1Y5NWVTTWc9PSIsInZhbHVlIjoiMzNESzh0MWZnWCtLZzRWOHFLazl6UWwzWkd3Tml4a2Npc0pMWlZKekdPbVY5enFSNG5INW91eTZORFFxT1FsV0xMTXJORitGN2s1MnpKNTZNZnNwaGlHNVNXY1NmUlkvRWo0MTVkMjdubVlUbGoyVVJQdFZVa3hYbWNQYzJwZXEiLCJtYWMiOiI2NzkyYWJmMTAwYzYxODBkYzU2ZTk4ODZmOWE2YzE4YmM1NDQwMDgwM2I4YjYxNWE4MzVhMzI4ZDM5Njk5NjYwIiwidGFnIjoiIn0%3D
//Host:              des50.myftp.org
//User-Agent:        AHC/2.1
//X-Forwarded-Proto: https
//Cookie: XSRF-TOKEN=VbPNhDY8Dz0hWuXgj6s8azHmp8uwt2vqoO5rkSlX; testmaglaravel_session=asmYbJPrvA86ZYxu3KfvDUY9jJwbsXjZ0kLapwWs
//
//notification_type=card-incoming
//&zip=
//&bill_id=
//&amount=9.70
//&firstname=
//&codepro=false
//&withdraw_amount=10.00
//&city=
//&unaccepted=false
//&label=7
//&building=
//&lastname=
//&datetime=2022-09-06T22%3A23%3A14Z&suite=
//&sender=
//&phone=
//&sha1_hash=6f7c9d805551449f0384589b6fd72c8bbb25275c
//&street=
//&flat=
//&fathersname=
//&operation_label=2aa9dbfd-0011-5000-a000-112d64aece00
//&operation_id=715818194137004004
//&currency=643
//&email=
