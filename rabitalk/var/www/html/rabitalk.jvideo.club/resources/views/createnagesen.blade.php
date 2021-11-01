@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div>
            @endif
        </div>
        <div class="col-12">
            <form action="/nagesen" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                        <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                            画像
                        </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        <input type="file" name="image">
                    </span>   
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        タイトル
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        <input type="text" name="title" maxlength="64" id="title" @if(isset($item)) value="{{$item->title}}" @else value = "{{ old('title') }}" @endif style="width:100%;height:2em"onKeyup="count_length('title','title_count',64)";>
                    </span>   
                </div>
                <div class="col-9 offset-3 pl-0">
                    <p id="title_count" class="counter">現在0文字</p>
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        タイプ
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        <input type="radio" name="type" value="1" checked>ライン内静止画
                        <input type="radio" name="type" value="2">全画面動画
                    </span>   
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        個数
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        <input type="text" name="count" maxlength="3" id="count" @if(isset($item)) value="{{$item->count}}" @else value = "{{ old('count') }}" @endif style="width:100%;height:2em"onKeyup="count_length('count','count_count',3)";>
                    </span>   
                </div>
                <div class="col-9 offset-3 pl-0">
                    <p id="count_count" class="counter">現在0文字</p>
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        金額
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        <input type="text" name="price" maxlength="6" id="price" @if(isset($item)) value="{{$item->price}}" @else value = "{{ old('price') }}" @endif style="width:100%;height:2em"onKeyup="price_length('price','price_price',6)";>
                    </span>   
                </div>
                <div class="col-9 offset-3 pl-0">
                    <p id="price_count" class="counter">現在0文字</p>
                </div>
                <div class="col-12">
                    <input type="submit" class="btn btn-primary btn-lg btn-block mt-3" value="投げ銭を登録する" />
                </div>
            </form>
        </div>
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
