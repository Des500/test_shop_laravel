@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    <div class="card">
        <div class="card-header"><h2>{{ $title }}</h2></div>
        <div class="card-body">

            <form action="{{ route('products.store') }}" method="POST" class="form-group create_product" enctype="multipart/form-data">
                @csrf
{{--                <input class="form-control cat_id" type="number" name="cat_id" placeholder="введите категорию" value="{{ $form['cat_id'] }}" required hidden>--}}
                <label for="">Выбрать категорию</label>
                <select class="form-select w-25"  name="category" required>
                    <option disabled value="">Выбрать категорию...</option>
                    @foreach($form['categories'] as $category)
                        <option value="{{ $category->id }}">{{ $category->id }} - {{ $category->title }}</option>
                    @endforeach
                </select>
                <br>

                <label for="title">Название товара</label>
                <input class="form-control" type="text" name="title" placeholder="введите название" value="{{ $form['title'] }}" required>
                <br>

                <label for="shot_desc">Кратое описание товара</label>
                <textarea class="form-control" name="shot_desc" id="" placeholder="введите короткое описание" required>{{ $form['shot_desc'] }}</textarea>
                <br>

                <label for="description">Описание товара</label>
                <textarea class="form-control" id="app_ckeditor" name="description" placeholder="введите описание">{{ $form['description'] }}</textarea>
                <br>

                <label for="price">Стоимость товара</label>
                <input class="form-control" type="number" name="price" placeholder="введите категорию" value="{{ $form['price'] }}" required>
                <br>

                <label for="description">Изображение товара</label>
                <input class="form-control" type="file" name="image" placeholder="выберите изображение" value="">
                <br>

                <div class="form-check form-switch">
                    <label for="in_stock" class="form-check-label">Есть на складе?</label>
                    <input type="checkbox" class="form-check-input"
                           name="in_stock" {{ $form['in_stock'] }}>
                </div>
                <br>

                <div class="form-check form-switch">
                    <label for="public" class="form-check-label">Опубликован?</label>
                    <input type="checkbox" class="form-check-input"
                           name="public" {{ $form['public'] }}>
                </div>
                <br>

                <div class="text-danger">{{ $message }}</div>
                <br>
{{--                {{ method_field('PUT') }}--}}
                <button class="btn btn-outline-primary btn-outline-primary" id="send">Сохранить</button>
            </form>

        </div>
    </div>
@endsection
