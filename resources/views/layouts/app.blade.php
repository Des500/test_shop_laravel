<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <title>{{ config('app.name', 'Laravel') }}</title>--}}
    <title>@yield('page_title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}?{{ time() }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<body class="antialiased">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">

            <div class="container">
                <a class="navbar-brand me-md-2" href="{{ route('main') }}">
                    <span class="logo">
                        <img src="/public/storage/images/logo.svg" alt="" width=55px" style="float: left">
                    </span>
                    {{ config('app.name', 'Laravel') }}
                    <div style="font-size: 16px">Мы знаем о Вас всё!</div>
                </a>
                <div class="ms-md-5"><i class="fa-solid fa-phone"></i> +7 927-207-91-12</div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span>Аккаунт </span><span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse ms-md-3" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about') }}">О компании</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact_form') }}">Обратная связь</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        Личный кабинет
                                    </a>
                                    <a class="dropdown-item" href="{{ route('adresses') }}">Адреса</a>
                                    <a class="dropdown-item" href="{{ route('home') }}">Заказы</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>


                            </li>
                        @endguest
                    </ul>
                </div>

            </div>
        </nav>

        <nav class="navbar navbar-expand-md navbar-light shadow-sm position-sticky top-0 container_menu_products">
            <div class="container mt-1">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('products') }}">Все товары</a></li>
                    </ul>

                    <div class="collapse navbar-collapse" id="navbarSupportedProducts">
                        <?php
                        $categories_navbar = \App\Models\Category::getlistnavbar();
                        ?>
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><span class="nav-link menu_separator"></span></li>
                            @foreach($categories_navbar as $item)

                                {{--                            <li class="nav-item"><a class="nav-link" href="{{ route('category.show', ['id' => $item->id]) }}">{{ $item->title }}</a></li>--}}
                                <?php
                                    $countProductsInCategory = \App\Models\Category::countProducts($item->id);
                                ?>
                                @if($countProductsInCategory > 0)
                                    <li class="nav-item"><a class="nav-link" href="{{ route('category.update', ['category' => $item->id]) }}">{{ $item->title }}</a></li>
                                @else
                                    @auth()
                                        @if(Auth::user()->role === 'admin')
                                            <li class="nav-item"><a class="nav-link text-decoration-line-through" href="{{ route('category.update', ['category' => $item->id]) }}">{{ $item->title }}</a></li>
                                        @endif
                                    @endauth
                                @endif
                            @endforeach
                            @auth()
                                @if(Auth::user()->role === 'admin')
                                    <li class="nav-item"><span class="nav-link menu_separator"></span></li>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" href="{{ route('products.create') }}">Создать товар</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-danger" href="{{ route('category.create') }}">Создать категорию</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>
                    </div>

                    <ul class="navbar-nav ms-auto">
                        <?php
                        $cart = new \App\Models\Cart();
                        $summa = $cart->summaProductsInCart()->summa;
                        ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary cart" href="{{ route('showcart') }}">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span class="ms-1">
                                        @if($summa==0)
                                        Пусто
                                    @else
                                        {{ $summa }} руб.
                                    @endif
                                    </span>
                            </a>
                        </li>
                    </ul>

                    <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedProducts" aria-controls="navbarSupportedProducts" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            </div>
        </nav>


        <div class="container">
            @include('blocks.messages')
            @yield('content')
        </div>
        <p></p>

        <footer class="bg-dark mt-5 py-4">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-center">
                    <div class="text-light me-auto mb-3">Все права защищены &copy; {{ config('app.name', 'Laravel') }}</div>
                    <div class="ms-auto d-flex justify-content-end social">
                        <i class="fa-brands fa-youtube"></i>
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-twitter"></i>
                        <i class="fa-brands fa-telegram"></i>
                    </div>
                </div>
                <div class="text-muted">Laravel v{{ Illuminate\Foundation\Application::VERSION }}</div>
            </div>
        </footer>

    </div>
{{--    Диалоговое окно--}}

    <div id="dialog" class="form_closed d-flex justify-content-center" title="Диалоговое окно"></div>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('public/js/app.js') }}?{{ time() }}"></script>
    <script src="{{ asset('public/js/shop.js') }}?{{ time() }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js" type="text/javascript" charset="utf-8"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#app_ckeditor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

</body>
</html>
