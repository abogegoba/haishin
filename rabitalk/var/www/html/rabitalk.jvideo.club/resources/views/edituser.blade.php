@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            @if($user->image!=null)
            <img src="/storage/{{$user->image}}" style="height:15vh;object-fit:cover;">
            @endif
        </div>
        <div class="col-12">
            <form action="/user/{{$user->id}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-3 text-right mt-2 d-flex align-items-center label">
                        <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                            写真
                        </span>
                    </div>
                    <div class="col-9 mt-2 pl-0">
                        <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#ff1493;">
                            <input type="file" name="image">
                        </span>   
                    </div>
                    <div class="col-3 text-right mt-2 d-flex align-items-center label">
                        <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                            ニックネーム
                        </span>
                    </div>
                    <div class="col-9 mt-2 pl-0">
                        <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#ff1493;">
                            <input type="text" name="name" maxlength="64" value="{{$user->name}}" style="width:100%">
                        </span>   
                    </div>
                    <div class="col-3 text-right mt-2 d-flex align-items-center label">
                        <span style="font-size:14px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;width:100%">
                            プロフィール
                        </span>
                    </div>
                    <div class="col-9 mt-2 pl-0">
                        <span style="font-size:16px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#ff1493;">
                            <textarea name="information" style="width:100%;height:50vh">{{$user->information}}</textarea>
                        </span>   
                    </div>
                    <div class="col-12">
                        <input type="submit" class="btn btn-primary btn-lg btn-block mt-3" value="写真を登録する" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
