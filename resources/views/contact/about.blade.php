@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    <h1>про компанию</h1>
    <p>Текст про компанию</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci autem eaque minima odio placeat quam ratione rerum tenetur vel veniam.</p>
@endsection
