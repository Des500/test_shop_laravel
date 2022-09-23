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
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ $title }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <table class="table table-content table-bordered table-striped table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th>#</th>
                                    <th>Телефон</th>
                                    <th>Адрес</th>
                                    <th>Изменен</th>
                                    <th>Изменить</th>
                                </tr>
                            </thead>
                            <tbody class="">
                    @foreach($adresses as $adress)
                                <tr class="">
                                    <th>{{ $adress->id  }}</th>
                                    <td>{{ $adress->contact_phone }}</td>
                                    <td>{{ $adress->contact_adress }}</td>
                                    <td>{{ $adress->updated_at }}</td>
                                    <td><a href="{{ route('adresses.edit', ['adress' => $adress->id]) }}" class="btn btn-outline-primary">Открыть</a></td>
                                </tr>
                    @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('adresses.create') }}" class="btn btn-outline-primary">Добавить адрес</a>
                </div>
            </div>
        </div>
    </div>
@endsection
