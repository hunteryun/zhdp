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
    // 字段类型管理
    Route::prefix('/field_type')->group(function(){
        Route::view('', 'user/field_type/index'); // 字段类型列表
        Route::view('add', 'user/field_type/add'); // 字段类型添加
        Route::view('edit', 'user/field_type/edit'); // 字段类型编辑
    });
    // 产品管理
    Route::prefix('/product')->group(function(){
        Route::view('', 'user/product/index'); // 产品列表
        Route::view('add', 'user/product/add'); // 产品添加
        Route::view('edit', 'user/product/edit'); // 产品编辑
        Route::prefix('/product_field')->group(function(){
            Route::view('', 'user/product/product_field/index'); // 产品字段管理
            Route::view('add', 'user/product/product_field/add'); // 产品字段添加
            Route::view('edit', 'user/product/product_field/edit'); // 产品字段编辑
        });
    });
    // 区域管理
    Route::prefix('/device_region')->group(function(){
        Route::view('', 'user/device_region/index'); // 区域列表
        Route::view('add', 'user/device_region/add'); // 区域编辑
    });
    // 房间管理
    Route::prefix('/device_room')->group(function(){
        Route::view('', 'user/device_room/index'); // 房间列表
        Route::view('add', 'user/device_room/add'); // 房间添加
        Route::view('edit', 'user/device_room/edit'); // 房间编辑
    });
    // 设备管理
    Route::prefix('/device')->group(function(){
        Route::view('', 'user/device/index'); // 设备列表
        Route::view('add', 'user/device/add'); // 设备添加
        Route::view('edit', 'user/device/edit'); // 设备编辑
        Route::prefix('/device_field')->group(function(){
            Route::view('', 'user/device/device_field/index'); // 设备字段管理
            Route::view('add', 'user/device/device_field/add'); // 设备字段添加
            Route::view('edit', 'user/device/device_field/edit'); // 设备字段编辑
        });
    });
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

