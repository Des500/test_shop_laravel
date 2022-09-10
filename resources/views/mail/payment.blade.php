@extends('mail.layouts.order')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
    Здравствуйте, {{ $transaction->user->name }}.<br>
    От Вас получена оплата по заказу <a href="{{ route('showorder', ['id' => $transaction->order_id]) }}">
        {{ $transaction->order_id }} от {{ $transaction->order->created_at }}
    </a> в сумме {{ $transaction->summa_order }} руб.<br>
    <hr>
    ВНИМАНИЕ!! ЭТО ТЕСТОВЫЙ МАГАЗИН!
    Если Вы случайно произвели оплату - пишите в вайбер +79272079112.
@endsection
