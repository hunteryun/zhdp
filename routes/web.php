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

// 登录 /index.php/login
Route::prefix('/login')->group(function(){
    Route::get('user', 'LoginController@user'); // 用户登录首页
});

// 用户 /index.php/user
Route::prefix('/user')->group(function(){
    // 首页
    Route::prefix('/index')->group(function(){
        Route::get('', 'User\\IndexController@index'); // 首页
        Route::get('console', 'User\\IndexController@console'); // 控制台
    });
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

