<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/kaiin', 'HomeController@kaiin');
Route::get('/tokutei', 'HomeController@tokutei');
Route::get('/privacy', 'HomeController@privacy');
Route::get('/senderlist', 'HomeController@senderlist');
Route::get('/playslist', 'HomeController@playslist');

Route::get('chat', 'ChatController@index');
Route::get('message', 'ChatController@message');
Route::get('iineon/{room}', 'IineController@iineon');
Route::get('iineoff/{room}', 'IineController@iineoff');

Route::get('iineontop/{room}', 'IineController@iineontop');
Route::get('iineofftop/{room}', 'IineController@iineofftop');

Route::get('iineonlist/{room}', 'IineController@iineonlist');
Route::get('iineofflist/{room}', 'IineController@iineofflist');

Route::get('ajax/chat', 'Ajax\ChatController@index'); // メッセージ一覧を取得
Route::get('ajax/flag', 'Ajax\ChatController@flag'); // メッセージ一覧を取得

Route::post('ajax/chat', 'Ajax\ChatController@create'); // チャット登録
Route::resource('user', 'UserController');
Route::resource('nagesen', 'NagesenController');
Route::resource('nagesenuser', 'NagesenUserController');
Route::resource('iine', 'IineController');
Route::resource('project', 'ProjectController');

Route::get('haishin', 'UserController@haishin');
Route::get('haishinoff', 'UserController@haishinoff');
