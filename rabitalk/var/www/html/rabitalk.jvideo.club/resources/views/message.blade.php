@inject('usr', 'App\Services\UserService')
@inject('nagesenuser', 'App\Services\NagesenUserService')
@inject('nagesen', 'App\Services\NagesenService')
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
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
</head>
<body style="background-color:#ffffe0">
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
        
        <div id="chat">
            <div class="row">
            <div class="col-12">         
                <div v-for="(m3, index) in messages3">
                <transition name="fade" style="transition-duration: 3s;
                    -webkit-transition-delay:2s;
                    -moz-transition-delay:2s;
                    -o-transition-delay:2s;
                    transition-delay:2s;">
                <img v-if="m3.type==2 && flag==0" :src="'/storage/'+m3.body" style="position:absolute;top:100px;width:100%;height:60%;object-fit:cover;"/>
                </transition>
                </div>
            </div>
            </div>
        <div class="row fixed-bottom" style="margin-bottom:80px">

            <div class="col-12">
                <div v-for="(m, index) in messages">
                    <div class="row" style="background:rgba(255,255,255,0.2)">
                    <!-- 登録された日時 -->
                    <!-- メッセージ内容 -->
                    <div class="col-3 col-xs-2">
                        <img :src="'/storage/'+m.user.image" style="width:24px;height:24px;object-fit:covor;float:left"/>
                        <span v-text="m.user.name"></span>
                    </div>
                    <div class="col-7 col-xs-8">
                    <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:400px;">
                    <img v-if="m.type==1" :src="'/storage/'+m.body" style="width:24px;height:24px;object-fit:covor;float:left"/>
                    <span v-if="m.type==1" v-text="m.user.name" style="drop-shadow: 6px 6px 6px rgba(255, 255, 255, .5)"></span>
                    <span v-if="m.type==1" >さんから投げ銭です。</span>
                    <span v-if="m.type==2" v-text="m.user.name" style="drop-shadow: 6px 6px 6px rgba(255, 255, 255, .5)"></span>
                    <span v-if="m.type==2" >さんから投げ銭です。</span>
                    <span v-if="m.type==0" v-text="m.body" style="drop-shadow: 6px 6px 6px rgba(255, 255, 255, .5)"></span>
                    </span>
                    </div>
                    <div class="col-2">
                    <span style="font-size:8px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:400px;">
                    <span v-text="m.created_at"></span>
                    </span>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-10">
                <input v-model="message" maxlength="64" style="width:100%;height:40px"></input>
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="room_id" value="{{$room}}">
            </div>
            <div class="col-2 d-grid gap-2">
                <button class="btn btn-info btn-block" type="button" @click="send()">送信</button>
            </div>
            <div class="col-12">
                <div class="row p-0">
                    @foreach($nagesenuser->list($user->id) as $nage)
                        <div class="col-1 p-0">
                            <div style="width:100%">
                                <button class="btn btn-link btn-block p-0" v-on:click="send2('{{$nagesen->get($nage->nagesen_id)->image}}',{{$nagesen->get($nage->nagesen_id)->type}})">
                                <img src="/storage/{{$nagesen->get($nage->nagesen_id)->image}}" style="width:100%;padding-top:0;">
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>  
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