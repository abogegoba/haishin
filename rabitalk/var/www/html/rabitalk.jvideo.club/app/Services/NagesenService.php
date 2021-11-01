<?php
//namespace App\Services\IineService;
namespace App\Services;

// modelのインポート
use App\Nagesen;

class NagesenService
{
  public function get($id)
  {
    $nagesen = Nagesen::where('id',$id)->first();
    if($nagesen == null) $nagesen = Nagesen::where('id',1)->first();
    return $nagesen;
  }

} // END class
