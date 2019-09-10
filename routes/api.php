<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// 用户 /index.php/api/user
// 
Route::prefix('/user')->group(function(){
    // Route::get('', 'Api\\UserController@index'); // 获取列表
    // Route::get('{id}', 'Api\\UserController@show'); // 获取指定id
    // Route::post('', 'Api\\UserController@store'); // 新增
    // Route::put('{id}', 'Api\\UserController@update'); // 更新
    // Route::delete('{id}', 'Api\\UserController@destroy'); // 删除
    // 
    Route::post('reg', 'Api\\User\\RegController@index'); // 注册
    Route::post('login', 'Api\\User\\LoginController@index'); // 登录
    // 字段类型 /index.php/api/field_type
    Route::prefix('/field_type')->group(function(){
        Route::get('', 'Api\\User\\FieldTypeController@index')->middleware('user.token'); // 获取列表
        Route::get('all', 'Api\\User\\FieldTypeController@all')->middleware('user.token'); // 获取所有数据
        Route::get('{id}', 'Api\\User\\FieldTypeController@show')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\FieldTypeController@store')->middleware('user.token'); // 新增
        Route::put('{id}', 'Api\\User\\FieldTypeController@update')->middleware('user.token'); // 更新
        Route::delete('{id}', 'Api\\User\\FieldTypeController@destroy')->middleware('user.token'); // 删除
    });
    // 产品 /index.php/api/product
    Route::prefix('/product')->group(function(){
        Route::get('', 'Api\\User\\ProductController@index')->middleware('user.token'); // 获取列表
        Route::get('all', 'Api\\User\\ProductController@all')->middleware('user.token'); // 获取所有数据
        Route::get('{id}', 'Api\\User\\ProductController@show')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\ProductController@store')->middleware('user.token'); // 新增
        Route::put('{id}', 'Api\\User\\ProductController@update')->middleware('user.token'); // 更新
        Route::delete('{id}', 'Api\\User\\ProductController@destroy')->middleware('user.token'); // 删除
        // 产品字段 /index.php/api/product_field
        Route::prefix('/product_field')->group(function(){
            Route::get('all', 'Api\\User\\ProductFieldController@all')->middleware('user.token'); // 获取所有数据
            Route::post('', 'Api\\User\\ProductFieldController@store')->middleware('user.token'); // 新增
            Route::put('{id}', 'Api\\User\\ProductFieldController@update')->middleware('user.token'); // 更新
            Route::delete('{id}', 'Api\\User\\ProductFieldController@destroy')->middleware('user.token'); // 删除
        });
    });
    // 设备区域
    Route::prefix('/device_region')->group(function(){
        Route::get('', 'Api\\User\\DeviceRegionController@index')->middleware('user.token'); // 设备区域列表
        Route::get('all', 'Api\\User\\DeviceRegionController@all')->middleware('user.token'); // 所有设备区域列表
        Route::post('', 'Api\\User\\DeviceRegionController@store')->middleware('user.token'); // 添加设备区域列表
        Route::put('{id}', 'Api\\User\\DeviceRegionController@update')->middleware('user.token'); // 更新设备区域列表
        Route::delete('{id}', 'Api\\User\\DeviceRegionController@destroy')->middleware('user.token'); // 删除设备区域列表
    });
    // 作物分类
    Route::prefix('/crop_class')->group(function(){
        Route::get('', 'Api\\User\\CropClassController@index')->middleware('user.token'); // 作物分类列表
        Route::post('', 'Api\\User\\CropClassController@store')->middleware('user.token'); // 添加作物分类列表
        Route::put('{id}', 'Api\\User\\CropClassController@update')->middleware('user.token'); // 更新作物分类列表
        Route::delete('{id}', 'Api\\User\\CropClassController@destroy')->middleware('user.token'); // 删除作物分类列表
        Route::get('top', 'Api\\User\\CropClassController@topAll')->middleware('user.token'); // 所有顶级作物分类列表
        Route::get('top/{id}', 'Api\\User\\CropClassController@topIdAll')->middleware('user.token'); // 获取指定id下的作物种类
    });
    // 设备房间
    Route::prefix('/device_room')->group(function(){
        Route::get('', 'Api\\User\\DeviceRoomController@index')->middleware('user.token'); // 设备房间列表
        Route::get('all', 'Api\\User\\DeviceRoomController@all')->middleware('user.token'); // 所有房间区域列表
        Route::post('', 'Api\\User\\DeviceRoomController@store')->middleware('user.token'); // 添加设备房间列表
        Route::get('{id}', 'Api\\User\\DeviceRoomController@show')->middleware('user.token'); // 获取指定id房间
        Route::put('{id}', 'Api\\User\\DeviceRoomController@update')->middleware('user.token'); // 更新设备房间列表
        Route::delete('{id}', 'Api\\User\\DeviceRoomController@destroy')->middleware('user.token'); // 删除设备房间列表
    });
    // 设备 /index.php/api/device
    Route::prefix('/device')->group(function(){
        Route::get('', 'Api\\User\\DeviceController@index')->middleware('user.token'); // 获取列表
        Route::get('all', 'Api\\User\\DeviceController@all')->middleware('user.token'); // 获取房间下的所有设备
        Route::get('{id}', 'Api\\User\\DeviceController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\DeviceController@store')->middleware('user.token'); // 新增
        Route::put('{id}', 'Api\\User\\DeviceController@update')->where('id', '[0-9]+')->middleware('user.token'); // 指定id更新(web界面操作)
        Route::delete('{id}', 'Api\\User\\DeviceController@destroy')->middleware('user.token'); // 删除
        // 硬件
        Route::put('{token}', 'Api\\User\\DeviceController@updateDeviceField')->where('token', '[0-9a-zA-Z]{60}')->middleware('user.token'); // 指定token更新(web界面操作)
        // 设备字段 /index.php/api/device_field
        Route::prefix('/device_field')->group(function(){
            Route::get('all', 'Api\\User\\DeviceFieldController@all')->middleware('user.token'); // 获取所有数据
        });
        // 设备字段日志 /index.php/api/device_field_log
        Route::prefix('/device_field_log')->group(function(){
            Route::get('', 'Api\\User\\DeviceFieldLogController@index'); // 获取列表
        });
    });
});
// 字段类型 /index.php/api/field_type
Route::prefix('/field_type')->group(function(){
    Route::get('', 'Api\\FieldTypeController@index'); // 获取列表
    Route::get('all', 'Api\\FieldTypeController@all'); // 获取所有数据
    Route::get('{id}', 'Api\\FieldTypeController@show'); // 获取指定id
    Route::post('', 'Api\\FieldTypeController@store'); // 新增
    Route::put('{id}', 'Api\\FieldTypeController@update'); // 更新
    Route::delete('{id}', 'Api\\FieldTypeController@destroy'); // 删除
});
// 设备区域 /index.php/api/ 
Route::prefix('/device_region')->group(function(){
    Route::get('', 'Api\\DeviceRegionController@index'); // 获取列表
    Route::get('all', 'Api\\DeviceRegionController@all'); // 获取所有数据
    Route::get('{id}', 'Api\\DeviceRegionController@show'); // 获取指定id
    Route::post('', 'Api\\DeviceRegionController@store'); // 新增
    Route::put('{id}', 'Api\\DeviceRegionController@update'); // 更新
    Route::delete('{id}', 'Api\\DeviceRegionController@destroy'); // 删除
});
// 设备房间(房间在区域下面) /index.php/api/device_room
Route::prefix('/device_room')->group(function(){
    Route::get('', 'Api\\DeviceRoomController@index'); // 获取列表
    Route::get('all', 'Api\\DeviceRoomController@all'); // 获取所有数据
    Route::get('{id}', 'Api\\DeviceRoomController@show'); // 获取指定id
    Route::post('', 'Api\\DeviceRoomController@store'); // 新增
    Route::put('{id}', 'Api\\DeviceRoomController@update'); // 更新
    Route::delete('{id}', 'Api\\DeviceRoomController@destroy'); // 删除
});
// 产品 /index.php/api/product
Route::prefix('/product')->group(function(){
    Route::get('', 'Api\\ProductController@index'); // 获取列表
    Route::get('{id}', 'Api\\ProductController@show'); // 获取指定id
    Route::post('', 'Api\\ProductController@store'); // 新增
    Route::put('{id}', 'Api\\ProductController@update'); // 更新
    Route::delete('{id}', 'Api\\ProductController@destroy'); // 删除
});
// 产品字段 /index.php/api/product_field
Route::prefix('/product_field')->group(function(){
    Route::get('', 'Api\\ProductFieldController@index'); // 获取列表
    Route::get('all', 'Api\\ProductFieldController@all'); // 获取所有数据
    Route::get('{id}', 'Api\\ProductFieldController@show'); // 获取指定id
    Route::post('', 'Api\\ProductFieldController@store'); // 新增
    Route::put('{id}', 'Api\\ProductFieldController@update'); // 更新
    Route::delete('{id}', 'Api\\ProductFieldController@destroy'); // 删除
});
// 设备 /index.php/api/device
Route::prefix('/device')->group(function(){
    Route::get('', 'Api\\DeviceController@index'); // 获取列表
    Route::get('{id}', 'Api\\DeviceController@show'); // 获取指定id
    Route::post('', 'Api\\DeviceController@store'); // 新增
    Route::put('{id}', 'Api\\DeviceController@update'); // 更新
    Route::delete('{id}', 'Api\\DeviceController@destroy'); // 删除
});
// 设备字段 /index.php/api/device_field
Route::prefix('/device_field')->group(function(){
    Route::get('', 'Api\\DeviceFieldController@index'); // 获取列表
    Route::get('all', 'Api\\DeviceFieldController@all'); // 获取所有数据
    Route::get('{id}', 'Api\\DeviceFieldController@show'); // 获取指定id
    Route::post('', 'Api\\DeviceFieldController@store'); // 新增
    Route::put('{id}', 'Api\\DeviceFieldController@update'); // 更新
    Route::delete('{id}', 'Api\\DeviceFieldController@destroy'); // 删除
});
// 兜底路由
Route::fallback(function () {
    throw new App\Exceptions\NotFoundUrl();
});