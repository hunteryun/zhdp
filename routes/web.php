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
    Route::get('reg', function(){
        return view('user/reg/index');
    }); // 用户注册
    Route::get('login', function(){
        return view('user/login/index');
    }); // 用户登录
    // 首页
    Route::prefix('/index')->group(function(){
        Route::get('', function(){
            return view('user/index/index');
        }); // 首页
        Route::get('console', 'User\\IndexController@console'); // 控制台
    });
    // 区域管理
    Route::prefix('/device_region')->group(function(){
        Route::get('', 'User\\DeviceRegionController@index'); // 首页
    });
    
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

