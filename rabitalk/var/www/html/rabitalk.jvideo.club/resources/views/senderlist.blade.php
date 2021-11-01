@inject('iine', 'App\Services\IineService')
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
                @foreach($loginusers as $user)
                    <div class="col-6 p-1">
                        <a href="/user/{{$user->id}}">
                            <div class="card">
                                <div class="card-header p-0">
                                    <img src="/storage/{{$user->image}}" style="width:100%;height:150px;object-fit: cover;">
                                    <div style="position:absolute;top:130px;right:10px">
                                        @if($iine->get($user->id) == 0)
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#bbb;">
                                            <a href="/iineonlist/{{$user->id}}">🤍</a> {{$iine->count($user->id)}}
                                            </span>  
                                        @else
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                                            <a href="/iineofflist/{{$user->id}}">💞</a> {{$iine->count($user->id)}}
                                            </span>  
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-0 pl-3">
                                    <div class="col-12 p-0">
                                        @switch($user->online)
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
                                            {{$user->name}}
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
