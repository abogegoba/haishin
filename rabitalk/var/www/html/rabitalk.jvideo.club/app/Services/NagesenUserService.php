<?php
//namespace App\Services\IineService;
namespace App\Services;

// modelのインポート
use App\NagesenUser;

class NagesenUserService
{
  public function get($id)
  {
    $nagesenuser = NagesenUser::where('id',$id)->first();
    if($nagesenuser == null) $nagesen = NagesenUser::where('id',1)->first();
    return $nagesen;
  }
  public function list($id)
  {
    $nagesenuser = NagesenUser::where('user_id',$id)->get();
    if($nagesenuser == null) $nagesenuser = NagesenUser::where('id',1)->first();
    return $nagesenuser;
  }

} // END class
