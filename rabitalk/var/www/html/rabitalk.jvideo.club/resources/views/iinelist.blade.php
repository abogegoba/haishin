@inject('iine', 'App\Services\IineService')
@inject('usr', 'App\Services\UserService')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● キャスト一覧
                    </span>
                </div>
                @foreach($iineusers as $user)
                    <div class="col-6 p-1">
                        <a href="/user/{{$user->room_id}}">
                            <div class="card">
                                <div class="card-header p-0">
                                    <img src="/storage/{{$usr->get($user->room_id)->image}}" style="width:100%;height:150px;object-fit: cover;">
                                    <div style="position:absolute;top:130px;right:10px">
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                                            <a href="/iineofflist/{{$user->room_id}}">💞</a> {{$iine->count($user->room_id)}}
                                            </span>  
                                    </div>
                                </div>
                                <div class="card-body p-0 pl-3">
                                    <div class="col-12 p-0">
                                        @switch($usr->get($user->room_id)->online)
                                            @case(0)
                                                <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                                                    ● OFFLINE
                                                </span>
                                                @break
                                            @case(2)
                                                <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#a55;width:100%">
                                                    ● 通話中
                                                </span>
                                                @break
                                            @case(1)
                                                <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#5a5;width:100%">
                                                    ● ONLINE
                                                </span>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="col-12 p-0">
                                        <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;">
                                            {{$usr->get($user->room_id)->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
