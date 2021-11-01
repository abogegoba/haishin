<?php
//namespace App\Services\IineService;
namespace App\Services;

// modelのインポート
use App\User;

class UserService
{
  public function get($id)
  {
    $user = User::where('id',$id)->first();
    if($user == null) $user = User::where('id',1)->first();
    return $user;
  }

} // END class
