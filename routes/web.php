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
Route::view('/', 'welcome'); 
// 用户 /index.php/user
Route::prefix('/user')->group(function(){
    Route::view('reg', 'user/reg/index'); // 用户注册
    Route::view('login', 'user/login/index'); // 用户登录
    Route::view('index', 'user/index/index'); // 首页
    Route::view('device_region', 'user/device_region/index'); // 区域管理
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

