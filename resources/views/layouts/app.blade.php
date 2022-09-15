<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- zvaigzduciu reikalai -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">




    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        const nextMonthUrl = "{{route('next-month')}}";
        const previousMonthUrl = "{{route('previous-month')}}";
        const dayUrl = "{{route('show-day')}}";
        const addToCartUrl = "{{route('add-to-cart')}}";
        const showNavCartUrl = "{{route('show-nav-cart')}}";
        const makeOrderUrl = "{{route('make-order')}}";
        const rateUrl = "{{route('front-rate')}}";

    </script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IM+Fell+English+SC&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h2 class="text-danger"><b>Ruby</b></h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto" style="display:flex; column-gap:20px;">
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
                        @if(Auth::user()->role > 9)
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Salons
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('salons-index')}}">Our Salons</a>
                                <a class="dropdown-item" href="{{ route('salons-create')}}">Create new salon</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Procedures
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('procedures-index')}}">Procedures</a>
                                <a class="dropdown-item" href="{{ route('procedures-create')}}">Create new procedure</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Masters
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('masters-index')}}">Masters</a>
                                <a class="dropdown-item" href="{{ route('masters-create')}}">Register a new master</a>
                            </div>
                        </li>
                        @elseif(Auth::user()->role > 0 && Auth::user()->role < 10) <li class="nav-item dropdown ">
                            <a id="navbarDropdown" class="nav-link" href="{{ route('front-salons')}}">
                                Salons
                            </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="{{route('front-procedures')}}">
                                    Procedures
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link" href="{{route('front-masters')}}">
                                    Masters
                                </a>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            <li class="nav-item dropdown nav--cart">
                            </li>
                            <li>
                            
                            </li>
                            @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @include('parts.msg')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: none;">
        <symbol id="star" x="0px" y="0px" viewBox="0 0 512 512">
            <polygon points="493.427,204.588 374.685,320.221 402.787,483.65 255.942,406.484 109.213,483.65 
    137.315,320.221 18.573,204.588 182.578,180.747 255.942,32.06 329.422,180.747 " />
            <path d="M97.732,499.448l30.299-176.21L0,198.56l176.84-25.706l79.097-160.301l79.219,160.301L512,198.56L383.969,323.237
    l30.298,176.203l-158.324-83.197L97.732,499.448z M255.941,396.726l135.365,71.134l-25.905-150.656l109.453-106.587l-151.167-21.975
    L255.947,51.569l-67.634,137.073L37.144,210.617l109.453,106.587l-25.903,150.649L255.941,396.726z" fill="black"/>
        </symbol>
    </svg>
</body>
</html>
