
@extends('layouts.app')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection


@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
    <h2 class="text-danger">ВНИМАНИЕ! ЭТО ТЕСТОВЫЙ МАГАЗИН!</h2>
    <h4 class="text-danger">Совершив оплату Вы не получите какого либо товара или услуги!</h4>
    </div>
    <form method="POST" action="https://yoomoney.ru/quickpay/confirm.xml" class="card w-50 mt-3 ms-auto me-auto">
        <input type="hidden" name="receiver" value="{{ $paycontent->receiver }}">
        <input type="hidden" name="formcomment" value="{{ $paycontent->formcomment }}">
        <input type="hidden" name="short-dest" value="{{ $paycontent->short_dest }}">
        <input type="hidden" name="label" value="{{ $paycontent->label }}">
        <input type="hidden" name="quickpay-form" value="shop">
        <input type="hidden" name="targets" value="{{ $paycontent->targets }}">
        <input type="hidden" name="successURL" value="{{ $paycontent->successURL }}">
        <input type="hidden" name="sum" value="{{ $paycontent->sum }}" data-type="number">
        <input type="hidden" name="need-fio" value="{{ $paycontent->need_fio }}">
        <input type="hidden" name="need-email" value="{{ $paycontent->need_email }}">
        <input type="hidden" name="need-phone" value="{{ $paycontent->need_phone }}">
        <input type="hidden" name="need-address" value="{{ $paycontent->need_address }}">
        <input type="hidden" name="paymentType" value="AC" checked>
        <div class="card-header">
            <h4>
                {{ $title }}
            </h4>
        </div>
        <div class="card-body">
            <p>Сумма {{ $paycontent->sum }} рублей</p>
            <p>Оплата Банковской картой</p>
            <input type="submit" class="btn btn-outline-success" value="Оплатить">
        </div>
    </form>
@endsection
