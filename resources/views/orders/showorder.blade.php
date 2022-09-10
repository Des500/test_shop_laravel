@extends('layouts.app')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
    <div class="d-flex justify-content-end pt-2">
        <a class="btn btn-warning" href="{{ route('home') }}">Назад</a>
        <hr>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Заказ {{ $order->id  }} от {{ $order->created_at }}
                    </h4>
                </div>
<!--                --><?//=print_r($order)?>

                <div class="card-body">
                        <table class="table table-content table-bordered table-striped table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th>Название</th>
                                    <th>Миниатюра</th>
                                    <th>Количество</th>
                                </tr>
                            </thead>
                            <tbody class="">
                            @foreach($order->products as $item)
                                <tr class="">
                                    <th>
                                        <a href="{{ route('products.show', ['product' => $item->product->id]) }}" class="">
                                            <h5>{{ $item->product->title }}</h5>
                                        </a>
                                    </th>
                                    <td>
                                        <a href="{{ route('products.show', ['product' => $item->product->id]) }}" class="">
                                            <img src="/public/storage/images/products/{{ $item->product->image }}"
                                                 alt="{{ $item->product->image }}" class="img-thumbnail" width="50px">
                                        </a>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    <div class="d-flex justify-content-start align-items-center">
                        <span class="text-primary me-3">Сумма заказа <b>{{ $order->summa }} рублей</b>.</span>
                        <span class="text-primary me-3">Статус заказа <b>{{ $orderstatus[$order->order_status] }}</b></span>
                        @auth()
                            @if(Auth::user()->role === 'admin')
                                <select class="form-select w-25"
                                        onchange="(document.querySelector('form.orderstatus input.orderstatus').value = this.value.split('|')[1])">
                                    <option selected disabled value="" class="orderstatus">Изменить статус...</option>
                                    @foreach($orderstatus as $key => $item)
                                        <option>{{ $item }}|{{ $key }}</option>
                                    @endforeach
                                </select>
                            @endif
                        @endauth
                    </div>
                    <hr>
                    <div class="d-flex justify-content-start">
                        @if(Auth::user()->id == $order->user_id)
                            @if($order->order_status === array_keys($orderstatus)[0])
                                <a href="{{ route('paymentorder', ['id' => $order->id]) }}" class="btn btn-outline-success me-3">Оплатить</a>
                            @endif
                            <a href="{{ route('ordertocart', ['id' => $order->id]) }}" class="btn btn-outline-primary me-3">Добавить заказ в корзину</a>
                        @endif
                        @auth()
                            @if(Auth::user()->role === 'admin')
                                <form action="{{ route('changeorderstatus') }}" method="POST" class="orderstatus">
                                    @csrf
                                    <input type="hidden" name="orderstatus" value="" class="orderstatus">
                                    <input type="hidden" name="order_id" value="{{ $order->id  }}">
                                    <button type="submit" class="btn btn-outline-danger">Изменить статус</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
