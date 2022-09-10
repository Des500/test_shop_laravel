@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    <div class="mt-3">
        <a class="btn btn-warning" onclick="history.back();return false;">Назад</a>
        <hr>
    </div>
    <div class="card">
        <div class="card-header"><h2>{{ $product->title }}</h2></div>

        <div class="card-body">

            <form action="{{ route('products.update', ['product' => $product->id]) }}" method="POST" class="form-group" enctype="multipart/form-data">
                @csrf

                {{--                <input class="form-control cat_id" type="number" name="cat_id" placeholder="введите категорию" value="{{ $form['cat_id'] }}" required hidden>--}}
                <label for="">Выбрать категорию</label>
                <select class="form-select w-25"  name="category" required>
{{--                    <option selected disabled value="">Выбрать категорию...</option>--}}
                    @foreach($categories as $category)
                        <option
                            @if($product->category_id == $category->id)
                                selected
                            @endif
                        >{{ $category->id }} - {{ $category->title }}</option>
                    @endforeach
                </select>
                <br>

                <label for="title">Название товара</label>
                <input class="form-control" type="text" name="title" placeholder="введите название" value="{{ $product->title }}" required>
                <br>

                <label for="shot_desc">Кратое описание товара</label>
                <textarea class="form-control" name="shot_desc" id="" placeholder="введите короткое описание" required>{{ $product->shot_desc }}</textarea>
                <br>

                <label for="description">Описание товара</label>
                <textarea class="form-control" id="app_ckeditor" name="description" placeholder="введите описание">{{ $product->description }}</textarea>
                <br>

                <label for="price">Стоимость товара</label>
                <input class="form-control" type="number" name="price" placeholder="введите категорию" value="{{ $product->price }}" required>
                <br>

                <div>Current image: </div>
                <img src="/public/storage/images/products/{{ $product->image }}"
                     alt="{{ $product->image }}" class="img-thumbnail"
                     style="max-width: 200px">
                <p></p>
                <input class="form-control" type="file" name="image" placeholder="введите картинку" value="">
                <br>

                <div class="form-check form-switch">
                    <label for="in_stock" class="form-check-label">Есть на складе?</label>
                    <input type="checkbox" class="form-check-input"
                           name="in_stock"
                           @if($product->in_stock)
                               checked
                           @endif
                    >
                </div>
                <br>

                <div class="form-check form-switch">
                    <label for="public" class="form-check-label">Опубликован?</label>
                    <input type="checkbox" class="form-check-input"
                           name="public"
                           @if($product->public)
                               checked
                           @endif
                    >
                </div>
                <br>

                <div class="text-danger">{{ $message }}</div>
                <br>
                {{ method_field('PUT') }}
                <button class="btn btn-outline-primary btn-outline-primary" id="send">Отправить</button>
            </form>


        </div>
    </div>
@endsection
