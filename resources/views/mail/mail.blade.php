@extends('layouts.app')

@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection

@section('content')
    Это тестовое письмо <br>
    @if(isset($text))
        {{ $text }}
    @endif
@endsection
