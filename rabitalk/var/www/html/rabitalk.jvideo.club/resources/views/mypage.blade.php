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

                    <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                    💞 {{$iine->count($user->id)}}
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
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/user/{{$user->id}}/edit">プロファイルを修正する</a>
                </div>
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/nagesenuser/{{$user->id}}">購入投げ銭一覧</a>
                </div>
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/nagesen">投げ銭購入</a>
                </div>
                @if($user->senderflag > 0)
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/project/create">スケジュール登録</a>
                </div>
                @endif
                @if($user->senderflag == 0)
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/haishin">配信者登録する</a>
                </div>
                @else
                <div class="col-8 offset-2 mt-4">
                    <a class="btn btn-info btn-block" href="/haishinoff">配信者登録を解除する</a>
                </div>
                @endif
                <div class="col-4 offset mt-5">
                    <a class="btn btn-link btn-block" href="/kaiin">会員規約</a>
                </div>
                <div class="col-4 offset mt-5">
                    <a class="btn btn-link btn-block" href="/tokutei">特定商取引による表記</a>
                </div>
                <div class="col-4 offset mt-5">
                    <a class="btn btn-link btn-block" href="/privacy">プライバシーポリシー</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
