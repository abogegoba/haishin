<div class="col-6 col-md-4 p-1">
                        <a href="/user/{{$user->id}}">
                            <div class="card">
                                <div class="card-header p-0">
                                    <img src="/storage/{{$user->image}}" style="width:100%;height:150px;object-fit: cover;">
                                    <div style="position:absolute;top:130px;right:10px">
                                        @if($iine->count($user->id) == 0)
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#bbb;">
                                            <a href="/iineontop/{{$user->id}}">🤍</a> {{$iine->count($user->id)}}
                                            </span>  
                                        @else
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                                            <a href="/iineofftop/{{$user->id}}">💞</a> {{$iine->count($user->id)}}
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