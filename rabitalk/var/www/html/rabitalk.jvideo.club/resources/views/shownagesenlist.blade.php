@inject('nage', 'App\Services\NagesenService')
@extends('layouts.app')

@section('content')
<style>
    .rect-wrap {
    width: 50% ;
    }
    .rect{
    width : 100% ;
    padding-top : 100% ;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        @foreach($nagesens as $nagesen)
            <div class="col-12" style="border:1px solid #000">
                <div class="row">
                    <div class="col-3 p-0" style="width:50%">
                        <img class="p-0" src="/storage/{{$nagesen->image}}" style="width:100%;padding-top:0;">
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-12">
                                <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#000;">
                                    {{$nagesen->title}}
                                </span>   
                            </div>
                            <div class="col-9">
                                <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#000;">
                                    表示タイプ:@if($nagesen->type == 1) 通常 @else 全画面 @endif
                                </span>
                            </div>
                            <div class="col-9">
                                <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#000;">
                                    購入個数:{{$nagesen->count}}
                                </span>   
                            </div>
                            <div class="col-9">
                                <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#000;">
                                    金額:{{$nagesen->price}}ポイント
                                </span>   
                            </div>
                            <div class="col-9">
                                <form action="/nagesenuser" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="nagesen" value="{{$nagesen->id}}">
                                <input type="hidden" name="count" value="{{$nagesen->count}}">
                                <button class="btn btn-info btn-block">購入する</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script type="text/javascript">
/* 文字数カウント
引数： 入力フィールドID、カウント表示コンテナID、最大文字数（任意）*/
function count_length(Field,Messge,MaxLength){
    var Current = document.gepriceementById(Field).value.length;
    var ColorClass = "green";
    var Limit;
    if (MaxLength && MaxLength>0){
        var Limit = MaxLength - Current;
        if (Limit < 0 ){ColorClass="red";}
        document.gepriceementById(Messge).innerHTML = "現在"+
            Current+"文字 <span class='"+ColorClass+
            "'>あと"+Limit+"文字</span>";
    } else {
        document.gepriceementById(Messge).innerHTML = "現在"+
            Current+"文字";
    }
}
</script>
@endsection
