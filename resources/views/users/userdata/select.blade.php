@extends('layouts.app')
@section('page_title')
    @if(isset($title))
        Тестовый магазин + {{ $title }}
    @else
        Тестовый магазин
    @endif
@endsection
@section('content')
    <div class="card col-md-8 mt-3">
        <div class="card-header">{{ $title }}</div>
        <div class="card-body">

            <form action="{{ route('addorder') }}" method="POST" class="form-group select_adress">
                @csrf

                <label for="">Выбрать адрес</label>
                <select class="form-select w-100"  name="adress_id" required>
                    <option disabled value="">Выбрать адрес...</option>
                    @foreach($adresses as $adresses)
                        <option value="{{ $adresses->id }}">{{ $adresses->contact_adress }}</option>
                    @endforeach
                </select>
                <br>
{{--                {{ method_field('PUT') }}--}}
                <button class="btn btn-outline-primary btn-outline-primary" id="send">Выбрать</button>
                <a href="{{ route('adresses.create') }}" class="btn btn-outline-danger">Добавить адрес</a>
            </form>
        </div>
        <div class="card-footer">
            <p class="pt-2"><span id="contact_name"></span> <span id="contact_phone"></span> <span id="contact_adress"></span></p>
        </div>
    </div>
@endsection
