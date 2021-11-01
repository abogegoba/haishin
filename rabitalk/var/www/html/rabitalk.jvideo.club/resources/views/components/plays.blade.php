@inject('usr', 'App\Services\UserService')
<div class="col-6 col-md-4 p-1">
                        <a href="/user/{{$project->user_id}}">
                            <div class="card">
                                <div class="card-header p-0">
                                    <img src="/storage/{{$project->image}}" style="width:100%;height:150px;object-fit: cover;">
                                    <div style="position:absolute;top:130px;right:10px">
                                        @if($iine->count($project->user_id) == 0)
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#bbb;">
                                            <a href="/iineontop/{{$project->user_id}}">🤍</a> {{$iine->count($project->user_id)}}
                                            </span>  
                                        @else
                                            <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:500;color:#f00;">
                                            <a href="/iineofftop/{{$project->user_id}}">💞</a> {{$iine->count($project->user_id)}}
                                            </span>  
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-0 pl-3">
                                    <div class="col-12 p-0">
                                        @switch($usr->get($project->user_id)->online)
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
                                            {{$usr->get($project->user_id)->name}}
                                        </span>
                                    </div>
                                    <div class="col-12 p-0">
                                        <span style="font-size:12px;font-family: 'Kosugi Maru', sans-serif;font-weight:400;color:#000;">
                                            {{$project->date}}<br>
                                            {{$project->title}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>