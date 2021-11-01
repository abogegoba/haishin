@inject('iine', 'App\Services\IineService')
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="row">
                <div class="col-12 p-1">
                    <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#888;width:100%">
                        ● スケジュール一覧
                    </span>
                    @foreach($projects as $project)
                    @include('components.plays',['project'=>$project])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
