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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
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
                                        {{ __('Logout') }}
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
                        <a href="https://sports.jvideo.club:8449/presenter.html?room=20"><img src="/imgs/vounge-icon3.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                    @else
                    <div class="col-2">
                        <a href="/news"><img src="/imgs/vounge-icon6.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                    @endif
                @else
                    <div class="col-2">
                        <a href="/news"><img src="/imgs/vounge-icon6.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                    </div>
                @endif
                <div class="col-2">
                    <a href="/follow"><img src="/imgs/vounge-icon4.png" style="width:100%;max-height:60px;object-fit:contain;"></a>
                </div>
                <div class="col-2">
                    <a href="/mypage/{{Auth::id()}}/edit"><img src="/imgs/vounge-icon5.png" style="width:100%;max-height:60px;object-fit:contain;">
                </div>
            </div>
        </footer>
    </div>
    </div>
    <script src="/js/app.js"></script>
    <script>

        new Vue({
            el: '#chat',
            data: {
                message: '',
                message2: '',
                flag: 0,
                flag2: 0,
                timerObj: null,
                messages: [],
                messages3: []
            },
            computed: {
                reverseMessages() {
                return this.message.slice().reverse();
                },
            },
            methods: {
                getMessages() {

                    this.flag=1;
                    const url = '/ajax/chat?room={{$room}}';
                    axios.get(url)
                        .then((response) => {
                            this.messages = response.data.slice().reverse();
                        });
                    const url3 = '/ajax/flag?room={{$room}}';
                    axios.get(url3)
                        .then((response3) => {
                            this.messages3 = response3.data.slice().reverse();
                            if(this.messages3==null) this.flag=1; else this.flag=0;
                        });
                    this.timer();
                },
                endMessages:function() {
                    this.flag=2;
                    const url = '/ajax/chat?room={{$room}}';
                    axios.get(url)
                        .then((response) => {
                            this.messages = response.data.slice().reverse();
                        });
                        console.log(">>>>>>>>>>3"+this.flag);
                },
                send() {
                    const url = '/ajax/chat';
                    const params = { message: this.message, user_id:{{$user->id}}, room_id:{{$room}}, type:0};
                    axios.post(url, params)
                        .then((response) => {
                            // 成功したらメッセージをクリア
                            this.message = '';
                        });

                },
                init_map() {
                console.log('呼ばれた');
                this.flag=0;
                },
                timer(){
                    console.log(">>>>>>>>>>1");
                    timerObj = setTimeout(this.log, 3000);
                },
                send2:function(message2,type2) {
                const url = '/ajax/chat';
                const params = { message: message2, user_id:{{$user->id}}, room_id:{{$room}}, type:type2};
                axios.post(url, params)
                    .then((response) => {
                        // 成功したらメッセージをクリア
                        this.message = '';
                    });
                },
                timer:function(){
                    console.log(">>>>>>>>>>1");
                    this.flag=1;
                    timerObj = setTimeout(this.log, 3000);
                },
                log:function(){
                    console.log(">>>>>>>>>>2");
                    this.endMessages();
                },
 
            },
            mounted() {

                this.getMessages();

                Echo.channel('chat')
                    .listen('MessageCreated', (e) => {
                        this.getMessages(); // メッセージを再読込
                    });

            }
        });

    </script>
    <script>
export default {
  data() {
    return {
      show: false,
    };
  },
};
</script>

<style scoped>

.fade-enter {
  opacity: 1;
}
.fade-enter-active {
  transition: 7s;
}
.fade-enter-to {
  opacity: 0;
}
.fade-leave {
  opacity: 1;
}
.fade-leave-active {
  transition: 7s;
  transition-duration: 7s;
  -webkit-transition-delay:4s;
  -moz-transition-delay:4s;
  -o-transition-delay:4s;
  transition-delay:4s;
}
.fade-leave-to {
  opacity: 0;
}
</style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>
