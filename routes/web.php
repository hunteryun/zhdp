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
// 首页
Route::get('/', function () {
    return view('welcome');
});

// 用户 /index.php/user
Route::prefix('/user')->group(function(){
    // 首页
    Route::prefix('/index')->group(function(){
        Route::get('', 'User\\IndexController@index'); // 首页
    });
});


