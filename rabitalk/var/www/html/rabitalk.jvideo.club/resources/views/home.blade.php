@inject('iine', 'App\Services\IineService')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● オンラインキャスト
                    </span>
                </div>
                @foreach($loginusers as $user)
                    @include('components.item',['user'=>$user])
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● 新着
                    </span>
                </div>
                @foreach($sendusers as $user)
                    @include('components.item',['user'=>$user])
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● おすすめ
                    </span>
                </div>
                @foreach($sendusers as $user)
                    @include('components.item',['user'=>$user])
                @endforeach
            </div>
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● 今後の予定
                    </span>
                </div>
                @foreach($projects as $project)
                    @include('components.plays',['project'=>$project])
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
