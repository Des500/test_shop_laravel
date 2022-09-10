@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    <div class=""><h2>{{ $title }}</h2></div>

        @if(count($products->cart)>0)

            <div class="show-products">
                <div class="row product_cart">
                    <div class="col-2">

                    </div>
                    <div class="col-4">
                        <h5>Название</h5>
                    </div>
                    <div class="col-2">
                        Количество
                    </div>
                    <div class="col-2">
                        Сумма
                    </div>
                    <div class="col-2">
                    </div>
                </div>
                <hr>


                @foreach($products->cart as $item)
                    <div class="row product_cart" id="product_{{ $item['product']->id }}">
                        <a href="{{ route('products.show', ['product' => $item['product']->id]) }}" class="col-2">
                            <img src="/public/storage/images/products/{{ $item['product']->image }}"
                                 alt="{{ $item['product']->image }}" class="img-thumbnail">
                        </a>
                        <a href="{{ route('products.show', ['product' => $item['product']->id]) }}" class="col-4">
                            <h5>{{ $item['product']->title }}</h5>
                        </a>
                        <span class="col-2">
                            <input type="number" name="product_quantity" value="{{ $item['quantity'] }}" id="input_{{ $item['product']->id }}" class="product_quantity"> шт.
                        </span>
                        <div class="col-2">
                            <span class="product_price">{{ $item['summa'] }}</span> руб.
                        </div>

                        <div class="col-2 me-auto">
                            <div class="btn btn-outline-primary cart_del_button" id="btn_{{ $item['product']->id }}">Удалить</div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
            <div class="btn-cart d-flex justify-content-between">
                <a href="{{ route('buycart') }}" class="btn btn-success cart_buy_button me-auto">Приобрести за <b><span>{{ $products['summa'] }}</span></b> рублей</a>
                <a href="{{ route('clearcart') }}" class="btn btn-outline-danger cart_clear_button ms-auto">Очистить корзину</a>
            </div>
        @else
            <p>Корзина пуста</p>
        @endif

@endsection
