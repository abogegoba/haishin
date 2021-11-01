<?php

namespace App\Http\Controllers;

use App\NagesenUser;
use Illuminate\Http\Request;

use Auth;

class NagesenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = Auth::user();
        //
        $nagesenuser = new NagesenUser();
        $nagesenuser->nagesen_id = $request->nagesen;
        $nagesenuser->user_id = $user->id;
        $nagesenuser->count = $request->count;
        $nagesenuser->save();
        return redirect('/nagesenuser/'.$nagesenuser->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NagesenUser  $nagesenUser
     * @return \Illuminate\Http\Response
     */
    public function show(NagesenUser $nagesenUser)
    {
        //
        $user = Auth::user();
        
        $nagesenusers = Nagesenuser::where('user_id',$user->id)->paginate(5);
        return view('shownagesenuser',compact('nagesenusers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NagesenUser  $nagesenUser
     * @return \Illuminate\Http\Response
     */
    public function edit(NagesenUser $nagesenUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NagesenUser  $nagesenUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NagesenUser $nagesenUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NagesenUser  $nagesenUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(NagesenUser $nagesenUser)
    {
        //
    }
}
