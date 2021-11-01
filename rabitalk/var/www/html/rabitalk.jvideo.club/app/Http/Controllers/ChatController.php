<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message;
use Auth;
class ChatController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index() {
        $user = Auth::user();
        if (isset($_GET['room'])){
            $room = $_GET['room'];
        } else {
            $room = 0;
        }
        
        $messages = Message::with('user')->where('room_id',$room)->where('type','!=',99)->orderBy('id','desc')->get();
        
        return view('chat',compact('user','room','messages'));
    }
    public function message() {
        $user = Auth::user();
        if (isset($_GET['room'])){
            $room = $_GET['room'];
        } else {
            $room = 0;
        }
        
        $messages = Message::with('user')->where('room_id',$room)->where('type','!=',99)->orderBy('id','desc')->get();
        
        return view('message',compact('user','room','messages'));
    }
}
