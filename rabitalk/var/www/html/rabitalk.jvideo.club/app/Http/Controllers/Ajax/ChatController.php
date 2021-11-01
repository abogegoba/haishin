<?php

namespace App\Http\Controllers\Ajax;

use App\Events\MessageCreated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index() {// 新着順にメッセージ一覧を取得
        if (isset($_GET['room'])){
            $room = $_GET['room'];
        } else {
            $room = 0;
        }
        return \App\Message::with('user')->where('room_id',$room)->orderBy('id', 'desc')->limit(5)->get();
    }
    public function flag() {// 新着順にメッセージ一覧を取得
        if (isset($_GET['room'])){
            $room = $_GET['room'];
        } else {
            $room = 0;
        }
        $message = \App\Message::with('user')->where('room_id',$room)->orderBy('id', 'desc')->limit(1)->get();
        
        return $message;
    }
    
    public function create(Request $request) { // メッセージを登録
    
        $message = \App\Message::create([
            'body' => $request->message,
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'type' => $request->type,
        ]);
    	event(new MessageCreated($message));
    }
}
