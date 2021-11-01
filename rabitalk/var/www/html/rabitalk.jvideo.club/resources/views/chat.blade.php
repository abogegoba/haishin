@inject('usr', 'App\Services\UserService')
@inject('nagesenuser', 'App\Services\NagesenUserService')
@inject('nagesen', 'App\Services\NagesenService')
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body style="background-color: rgba(0, 0, 0, 0);">
        <div id="chat">
        <div class="row">
            <div class="col-12">         
                <div v-for="(m3, index) in messages3">
                <transition name="fade" style="transition-duration: 3s;
                    -webkit-transition-delay:2s;
                    -moz-transition-delay:2s;
                    -o-transition-delay:2s;
                    transition-delay:2s;">
                <img v-if="m3.type==2 && flag==0" :src="'/storage/'+m3.body" style="position:absolute;top:0px;width:100%;height:70%;object-fit:cover;"/>
                </transition>
                </div>
            </div>
            </div>
        <div class="row fixed-bottom">
            <div class="col-12">
                <div v-for="(m, index) in messages">
                    <div class="row" style="background:rgba(255,255,255,0.2)">
                    <!-- 登録された日時 -->
                    <!-- メッセージ内容 -->
                    <div class="col-3 col-xs-2">
                        <img :src="'/storage/'+m.user.image" style="width:24px;height:24px;object-fit:covor;float:left"/>
                        <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:400px;" v-text="m.user.name"></span>
                    </div>
                    <div class="col-7 col-xs-8">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:400px;">
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
                                <button  class="btn btn-link btn-block p-0" v-on:click="send2('{{$nagesen->get($nage->nagesen_id)->image}}',{{$nagesen->get($nage->nagesen_id)->type}})">
                                <img src="/storage/{{$nagesen->get($nage->nagesen_id)->image}}" style="width:100%;padding-top:0;">
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>  
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