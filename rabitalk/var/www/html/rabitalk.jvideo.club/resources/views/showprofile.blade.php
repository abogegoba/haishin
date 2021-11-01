@inject('iine', 'App\Services\IineService')
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            @if($user->image!=null)
            <img src="/storage/{{$user->image}}" style="height:15vh;object-fit:cover">
            @endif
        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-3 text-right mt-2 d-flex align-items-center label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        ニックネーム
                    </span>
                </div>
                <div class="col-6 mt-2 pl-0">
                    <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#ff1493;">
                        {{$user->name}}
                    </span>   
                </div>
                <div class="col-3 mt-2 pl-0">
                @if($iine->get($user->id) == 0)
                    <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#bbb;">
                    <a href="/iineon/{{$user->id}}">🤍</a> {{$iine->count($user->id)}}
                @else
                    <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                    <a href="/iineoff/{{$user->id}}">💞</a> {{$iine->count($user->id)}}
                @endif
                    </span>   
                </div>
                <div class="col-3 text-right mt-2  label">
                    <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                        プロフィール
                    </span>
                </div>
                <div class="col-9 mt-2 pl-0" style="background:#ffffec">
                        {!!nl2br($user->information)!!}
                </div>
                <div class="col-12 mt-2 pl-0" style="background:#ffffec">
                        <a class="btn btn-info btn-block" href="https://rabitalk.jvideo.club:8444/?name={{Auth::id()}}&tel={{$user->id}}&room={{$user->id}}">電話をかける</a>
                </div>
                <div class="col-12 mt-2 pl-0" style="background:#ffffec">
                        <a class="btn btn-info btn-block" href="/message?room={{$user->id}}">メッセージを送る</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
