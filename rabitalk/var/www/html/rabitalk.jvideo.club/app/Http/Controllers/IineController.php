<?php

namespace App\Http\Controllers;

use App\Iine;
use Illuminate\Http\Request;
use App\User;
use Auth;
class IineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        
        $iineusers = Iine::where('user_id',$user->id)->get();
        return view('iinelist',compact('iineusers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $iine = new Iine();
        $iine->user_id = $request->user_id;
        $iine->room_id =$request->room_id;
        $iine->flag =$request->flag;
        $iine->save();        

        return redirect($request->url);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Iine  $iine
     * @return \Illuminate\Http\Response
     */
    public function show(Iine $iine)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Iine  $iine
     * @return \Illuminate\Http\Response
     */
    public function edit(Iine $iine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Iine  $iine
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Iine $iine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Iine  $iine
     * @return \Illuminate\Http\Response
     */
    public function destroy(Iine $iine)
    {
        //
    }

    public function iineon($room)
    {
        //
        $user = Auth::user();
        $iine = new Iine();
        $iine->user_id = $user->id;
        $iine->room_id =$room;
        $iine->flag =1;
        $iine->save();        

        return redirect("/user/".$room);
    }
    public function iineoff($room)
    {
        //
        $user = Auth::user();
        $iine = Iine::where('user_id',$user->id)->where('room_id',$room)->delete();

        return redirect("/user/".$room);
    }
    public function iineontop($room)
    {
        //
        $user = Auth::user();
        $iine = new Iine();
        $iine->user_id = $user->id;
        $iine->room_id =$room;
        $iine->flag =1;
        $iine->save();        

        return redirect("/home");
    }
    public function iineofftop($room)
    {
        //
        $user = Auth::user();
        $iine = Iine::where('user_id',$user->id)->where('room_id',$room)->delete();

        return redirect("/home");
    }
    public function iineonlist($room)
    {
        //
        $user = Auth::user();
        $iine = new Iine();
        $iine->user_id = $user->id;
        $iine->room_id =$room;
        $iine->flag =1;
        $iine->save();        

        return redirect("/senderlist");
    }
    public function iineofflist($room)
    {
        //
        $user = Auth::user();
        $iine = Iine::where('user_id',$user->id)->where('room_id',$room)->delete();

        return redirect("/senderlist");
    }
}
