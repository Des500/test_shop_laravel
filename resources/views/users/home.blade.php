@extends('layouts.app')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
    <h2>Заказы</h2>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Личный кабинет</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table table-content table-bordered table-striped table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th>#</th>
                                    <th>Дата</th>
                                    <th>Имя</th>
                                    <th>Сумма, руб</th>
                                    <th>Статус</th>
                                    <th>Посмотреть</th>
                                    <th>Оплатить</th>
                                </tr>
                            </thead>
                            <tbody class="">
                    @foreach($orders as $order)
                                <tr class="">
                                    <th>{{ $order->id  }}</th>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->summa }}</td>
                                    <td>{{ $orderstatus[$order->order_status] }}</td>
{{--                                    <td><a href="{{ $order->id  }}" class="btn btn-outline-primary">Открыть</a></td>--}}
                                    <td><a href="{{ route('showorder', ['id' => $order->id]) }}" class="btn btn-outline-primary">Открыть</a></td>
                                    <td>
                                        @if(Auth::user()->id == $order->user_id)
                                            @if($order->order_status === array_keys($orderstatus)[0])
                                                <a href="{{ route('paymentorder', ['id' => $order->id]) }}" class="btn btn-outline-primary">Оплатить</a>
                                            @else
                                                <div class="btn btn-outline-primary">Оплачено</div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                    @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
