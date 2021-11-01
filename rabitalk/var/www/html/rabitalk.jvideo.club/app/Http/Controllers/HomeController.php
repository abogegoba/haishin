<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Project;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $loginusers = User::where('online','>',0)->paginate(10);
        $sendusers = User::where('senderflag','>',0)->paginate(10);
        $projects = Project::orderBy('date','desc')->paginate(10);
        return view('home',compact('loginusers','sendusers','projects'));
    }

    public function senderlist()
    {
        $loginusers = User::paginate(10);
        return view('senderlist',compact('loginusers'));
    }
    public function playslist()
    {
        
        $projects = Project::orderBy('date','desc')->paginate(10);
        return view('playslist',compact('projects'));
    }
    public function kaiin()
    {
        $loginusers = User::where('online','>',0)->paginate(10);
        return view('kaiin',compact('loginusers'));
    }
    public function tokutei()
    {
        $loginusers = User::where('online','>',0)->paginate(10);
        return view('tokutei',compact('loginusers'));
    }
    public function privacy()
    {
        $loginusers = User::where('online','>',0)->paginate(10);
        return view('privacy',compact('loginusers'));
    }
}
