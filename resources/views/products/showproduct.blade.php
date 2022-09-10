@extends('layouts.app')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
        <div class="">

            <div class="d-flex justify-content-end pt-2">
                <a class="btn btn-warning" onclick="history.back();return false;">Назад</a>
                <hr>
            </div>
            <h2>{{ $product->title }}</h2>

            <div class="d-flex flex-wrap justify-content-start">
                <hr>

                {{--        <button class="btn btn-warning">registr</button>--}}
                <p></p>
                @if($product->image != "no_image.jpg")
                    <?php $width = 500; ?>
                @else
                    <?php $width = 200; ?>
                @endif
                <div style="max-width:{{ $width }}px" class="col-md-6">
                    <img src="/public/storage/images/products/{{ $product->image }}"
                         alt="{{ $product->image }}" class="img-thumbnail"
                         style="width: 100%">
                </div>
                <div class="text-black ms-4 col-md-6" id="{{ $product->id }}">
                    <article>{!! $product->description !!}</article>
                    @if($product->public)
                        @if($product->in_stock)
                            <p class="card-text">В наличии</p>
                        @else
                            <p class="card-text">Отсутствует на складе</p>
                        @endif
                    @else
                        <p class="card-text">Удален</p>
                    @endif
                    <div class="product" id="product_{{ $product->id }}">
                        <div class="product_title" hidden>{{ $product->title }}</div>
                        @if($product->in_stock && $product->public)
                            <p class="mt-1 fs-4">Купить за <span class="product_price">{{ $product->price }}</span> рублей</p>
                            <div class="d-flex justify-content-md-start align-items-center flex-wrap">
                                <span class="mt-1 me-3"><input type="number" name="product_quantity" value="1" id="input_{{ $product->id }}" class="product_quantity"> шт.</span>
                                <div class="btn btn-outline-primary mt-1 cart_add_button" id="btn_{{ $product->id }}">
                                    <i class="fa-solid fa-cart-arrow-down"></i>
                                    В корзину
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- Authentication Links -->
            @auth()
                @if(Auth::user()->role === 'admin')
                    <div>
                        <span>Author: {{ $user->name }}</span>
                        <span>Last update: {{ $product->updated_at }}</span>
                    </div>
                    <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST" class="form-group">
                        @csrf
                        <a class="btn btn-warning" href="{{ route('products.edit', ['product' => $product->id]) }}">
                            Изменить товар
                        </a>
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">
                            Удалить товар
                        </button>
                    </form>

                @endif
            @endauth

        </div>




@endsection
