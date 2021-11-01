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
                        <img src="/storage/{{$nagesen->image}}" style="max-width:640px;max-height:640px;object-fit:cover;">
                    </span>   
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        タイトル
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        {{$nagesen->title}}
                    </span>   
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        タイプ
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        @if($nagesen->type == 1) 通常;
                        @else
                        全画面
                        @endif
                    </span>   
                </div>
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        個数
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        {{$nagesen->count}}
                    </span>   
                </div>

                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        金額
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'M PLUS Rounded 1c', sans-serif;font-weight:500;color:#ff1493;">
                        {{$nagesen->price}}
                    </span>   
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
