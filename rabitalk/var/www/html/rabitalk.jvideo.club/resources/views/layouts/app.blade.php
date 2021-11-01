<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RABITALK') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .underline{
            border-bottom:1px solid #3cb371;
            border-left:5px solid #3cb371;
        }
        .wrapper{
            min-height: 100vh;
            position: relative;/*←相対位置*/
            padding-bottom: 80px;/*←footerの高さ*/
            box-sizing: border-box;/*←全て含めてmin-height:100vhに*/
        }
        footer{
            width: 100%;
            height:80px;
            background-color: #fff;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;/*←絶対位置*/
            bottom: 0; /*下に固定*/
        }
    </style>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
<link href="https://fonts.googleapis.com/css2?family=Kosugi+Maru&family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="background:#ffffe0">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/imgs/logo.png" style="height:48px">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">会員登録</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="wrapper">
        <main class="py-4" style="background:#ffffe0">
            @yield('content')
        </main>
        <footer>

            <div class="row">
                <div class="col-2 offset-1">
                    <a href="/home"><img src="/imgs/vounge-icon1.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                </div>
                <div class="col-2">
                    <a href="/senderlist"><img src="/imgs/vounge-icon2.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                </div>
                @php
                    $user=Auth::user();
                @endphp
                @if(isset($user))
                    @if($user->senderflag==1)
                    <div class="col-2">
                        <a href="https://rabitalk.jvideo.club:8444/presenter.html?name={{$user->id}}&room={{$user->id}}"><img src="/imgs/vounge-icon3.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                    @else
                    <div class="col-2">
                        <a href="/playslist"><img src="/imgs/vounge-icon6.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                    @endif
                @else
                    <div class="col-2">
                        <a href="/playslist"><img src="/imgs/vounge-icon6.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                @endif
                <div class="col-2">
                    <a href="/iine"><img src="/imgs/vounge-icon4.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                </div>
                <div class="col-2">
                    <a href="/user"><img src="/imgs/vounge-icon5.png" style="width:100%;max-height:60px;object-fit:contain;">
                </div>
            </div>
        </footer>
    </div>
    </div>
</body>
</html>
