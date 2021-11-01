<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    //
	protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
