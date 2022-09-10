@extends('mail.layouts.order')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
<p>name: {{ $contact->name }}</p>
<p>email: {{ $contact->email }}</p>
<p>phone: {{ $contact->phone }}</p>
<p>subject: {{ $contact->subject }}</p>
<p>Сообщение</p>
{{ $contact->message }}
@endsection
