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

    <!-- Authentication Links -->
    <div class="my-2">
        @auth()
            @if(Auth::user()->role === 'admin')
                @if(!empty($category_id))
                    <a class="btn btn-warning" href="{{ route('category.edit', ['category' => $category_id] ) }}">
                        Изменить категорию
                    </a>
                @endif
            @endif
        @endauth
    </div>


    @if(count($products)>0)

            <div class="d-flex flex-wrap justify-content-start show_products">
                @foreach($products as $product)
                    <div class="card mb-4 shadow-sm col-md-4 ps-2 pe-2 me-md-3">
                        <div class="card-header card_product_header">
                            <a class="nav-link" href="{{ route('products.show', ['product' => $product->id]) }}"><h4 class="">{{ $product->title }}</h4></a>
                        </div>
                        <div class="card-img-top card_product_image">
                            <a href="{{ route('products.show', ['product' => $product->id]) }}" title="{{ $product->title }}">
                                <img src="/public/storage/images/products/{{ $product->image }}"
                                     alt="{{ $product->image }}" class="card-img-top img-thumbnail">
                            </a>
                        </div>

                        <div class="card-body card_product_content">
                            <p class="card-text">{{ $product->shot_desc }}</p>
                        </div>
                        <div class="card-body card_product_price">
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
                                    <div class="">
                                        <p>Купить за <span class="product_price">{{ $product->price }}</span> рублей</p>
                                        <span><input type="number" name="product_quantity" value="1" id="input_{{ $product->id }}" class="product_quantity"> шт.</span>
                                        <div class="btn btn-outline-primary cart_add_button" id="btn_{{ $product->id }}">
                                            <i class="fa-solid fa-cart-arrow-down"></i>
                                            В корзину
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('products.show', ['product' => $product->id]) }}" class="text-muted nav-link">Подробнее...</a>
                        </div>

                    </div>
                @endforeach
            </div>
            {{ $products->links() }}
        @else
            <p>No products found</p>
        @endif

@endsection
