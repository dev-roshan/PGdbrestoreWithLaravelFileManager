<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/','HomeController@index');
Route::get('/apprestore','HomeController@custom');

Auth::routes();

Route::get('/home', 'HomeController@index');


// Route::get('login', function () {
//     auth()->loginUsingId(1);
//     return redirect()->intended();
// });
// Route::post('/restoredb', 'HomeController@restoredb');