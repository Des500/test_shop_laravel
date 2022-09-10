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
        <div class="card-header"><h2>{{ $category->title }}</h2></div>
        <div class="card-body">

            <form action="{{ route('category.update', ['category' => $category->id]) }}" method="POST" class="form-group create_categories" enctype="multipart/form-data">
                @csrf

                <label for="title">Название категории</label>
                <input class="form-control" type="text" name="title" placeholder="введите название" value="{{ $category->title }}" required>
                <br>

                <label for="description">Описание категории</label>
                <textarea class="form-control" id="app_ckeditor" name="description" placeholder="введите описание">{{ $category->description }}
                </textarea>
                <br>

                <div class="form-check form-switch">
                    <label for="public" class="form-check-label">Опубликован?</label>
                    <input type="checkbox" class="form-check-input"
                           name="public"
                           @if($category->public)
                               checked
                        @endif
                    >
                </div>
                <br>

                <div class="text-danger">{{ $message }}</div>
                <br>
                {{ method_field('PUT') }}
                <button class="btn btn-outline-primary btn-outline-primary" id="send">Сохранить</button>
            </form>

        </div>
    </div>
@endsection
