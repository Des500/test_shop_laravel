@extends('mail.layouts.order')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>
                        Заказ {{ $order->id  }} от {{ $order->created_at }} был отгружен
                    </h4>
                </div>

                <div class="card-body">
                    <table class="table table-content table-bordered table-striped table-hover">
                        <thead class="table-info">
                        <tr>
                            <th style="border-bottom: 1px solid">Название</th>
{{--                            <th style="border-bottom: 1px solid">Миниатюра</th>--}}
                            <th style="border-bottom: 1px solid">Количество</th>
                        </tr>
                        </thead>
                        <tbody class="">
                        @foreach($order->products as $item)
                            <tr class="">
                                <th style="border-bottom: 1px solid">
                                    <a href="{{ route('products.show', ['product' => $item->product->id]) }}" class="">
                                        <h5>{{ $item->product->title }}</h5>
                                    </a>
                                </th>
{{--                                <td style="border-bottom: 1px solid">--}}
{{--                                    <a href="{{ route('products.show', ['product' => $item->product->id]) }}" class="">--}}
{{--                                        <img src="/public/storage/images/products/{{ $item->product->image }}"--}}
{{--                                             alt="{{ $item->product->image }}" class="img-thumbnail" width="50px">--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                                <td style="border-bottom: 1px solid">{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-start">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
