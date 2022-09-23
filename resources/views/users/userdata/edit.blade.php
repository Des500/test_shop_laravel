@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    @include('users.blocks.usermenu')
    <div class="card col-md-8">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">

            <form action="{{ $form_action }}" method="POST" class="form-group create_adress">
                @csrf

                <label for="contact_name">Имя</label>
                <input class="form-control" type="text" name="contact_name" placeholder="Иван Скворцов" value="{{ $adress->contact_name }}" required>
                <br>

                <label for="contact_phone">Телефон</label>
                <input class="form-control" type="text" name="contact_phone" placeholder="+7999 999 99 99" value="{{ $adress->contact_phone }}" required>
                <br>

                <label for="contact_adress">Адрес</label>
                <textarea class="form-control" name="contact_adress" id="" placeholder="индекс, Город, Улица, дом-квартира" required>{{ $adress->contact_adress }}</textarea>
                <br>

                <div class="text-danger">{{ $message }}</div>
                <br>
                @if($method_put)
                {{ method_field('PUT') }}
                @endif
                <button class="btn btn-outline-primary btn-outline-primary" id="send">Сохранить</button>
            </form>

        </div>
    </div>
@endsection
