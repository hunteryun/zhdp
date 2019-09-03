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
    // 区域管理
    Route::prefix('/device_region')->group(function(){
        Route::view('', 'user/device_region/index'); // 区域列表
        Route::view('add', 'user/device_region/add'); // 区域添加
    });
    // 房间管理
    Route::prefix('/device_room')->group(function(){
        Route::view('', 'user/device_room/index'); // 房间列表
        Route::view('add', 'user/device_room/add'); // 房间添加
    });
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

