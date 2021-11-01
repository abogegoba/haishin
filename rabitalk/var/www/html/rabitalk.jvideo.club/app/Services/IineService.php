<?php
//namespace App\Services\IineService;
namespace App\Services;

// modelのインポート
use App\Iine;
use App\User;
use Auth;

class IineService
{
  public function get($room)
  {
    $user = Auth::user();
    $usr = Iine::where('user_id',$user->id)->where('room_id',$room)->first();
    if($usr == null) $flg=0; else $flg = 1;
    return $flg;
  }
  public function count($room)
  {
    $count = Iine::where('room_id',$room)->count();
    return $count;
  }

} // END class
