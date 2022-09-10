@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
        <h1>Обратная связь</h1>
        <p>Напишите свой вопрос</p>
        <div class="row justify-content-start">
            <div class="col-md-6">
                <form action="{{ route('contact_form_send') }}" method="post" class="form-group">
                    @csrf
                    <input class="form-control" type="text" name="name" placeholder="введите name" value="{{ $form->name }}">
                    <br>
                    <input class="form-control" type="email" name="email" placeholder="введите email" value="{{ $form->email }}">
                    <br>
                    <input class="form-control" type="text" name="phone" placeholder="введите телефон" value="{{ $form->phone }}">
                    <br>
                    <input class="form-control" type="text" name="subject" placeholder="введите тему" value="{{ $form->subject }}">
                    <br>
                    <textarea class="form-control" name="message" id="" placeholder="введите сообщение">{{ $form->message }}</textarea>
                    <br>
                    <div class="text-danger">{{ $message }}</div>
                    <br>
                    <button class="btn btn-outline-primary btn-outline-primary" id="send">Отправить</button>
                </form>
            </div>
        </div>
@endsection
