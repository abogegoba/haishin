<?php

namespace App\Http\Controllers;

use App\Nagesen;
use Illuminate\Http\Request;

use Validator;
use Auth;
class NagesenController extends Controller
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
        $nagesens = Nagesen::paginate(10);
        return view('shownagesenlist',compact('nagesens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('createnagesen');
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:64',
            'count' => 'required|numeric',
            'price' => 'required|numeric',
        ],
        [
               'price.required'  => '金額は必須項目です。',
               'price.numeric'  => '金額には数値のみ入力可能です。',
               'count.required'  => '個数は必須項目です。',
               'count.numeric'  => '個数には数値のみ入力可能です。',
               'title.required'  => 'タイトルは必須項目です。',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $nagesen = new Nagesen();
        $nagesen->title = $request->title;
        $nagesen->type = $request->type;
        $nagesen->count = $request->count;
        $nagesen->price = $request->price;
        

        if ($file = $request->image) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('storage/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }
        $nagesen->image = $fileName;

        $nagesen->save();

        return view('shownagesen',compact('nagesen'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nagesen  $nagesen
     * @return \Illuminate\Http\Response
     */
    public function show(Nagesen $nagesen)
    {
        //
        
        return view('shownagesen',compact('nagesen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nagesen  $nagesen
     * @return \Illuminate\Http\Response
     */
    public function edit(Nagesen $nagesen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nagesen  $nagesen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nagesen $nagesen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nagesen  $nagesen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nagesen $nagesen)
    {
        //
    }
}
