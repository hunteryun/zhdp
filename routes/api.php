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
Route::prefix('/user')->group(function(){
    Route::get('', 'UserController@index'); // 获取列表
    Route::get('{id}', 'UserController@show'); // 获取指定id
    Route::post('', 'UserController@store'); // 新增
    Route::put('{id}', 'UserController@update'); // 更新
    Route::delete('{id}', 'UserController@destroy'); // 删除
});
// 字段类型 /index.php/api/field_type
Route::prefix('/field_type')->group(function(){
    Route::get('', 'FieldTypeController@index'); // 获取列表
    Route::get('all', 'FieldTypeController@all'); // 获取所有数据
    Route::get('{id}', 'FieldTypeController@show'); // 获取指定id
    Route::post('', 'FieldTypeController@store'); // 新增
    Route::put('{id}', 'FieldTypeController@update'); // 更新
    Route::delete('{id}', 'FieldTypeController@destroy'); // 删除
});
// 设备区域 /index.php/api/ 
Route::prefix('/device_region')->group(function(){
    Route::get('', 'DeviceRegionController@index'); // 获取列表
    Route::get('all', 'DeviceRegionController@all'); // 获取所有数据
    Route::get('{id}', 'DeviceRegionController@show'); // 获取指定id
    Route::post('', 'DeviceRegionController@store'); // 新增
    Route::put('{id}', 'DeviceRegionController@update'); // 更新
    Route::delete('{id}', 'DeviceRegionController@destroy'); // 删除
});
// 设备房间(房间在区域下面) /index.php/api/device_room
Route::prefix('/device_room')->group(function(){
    Route::get('', 'DeviceRoomController@index'); // 获取列表
    Route::get('all', 'DeviceRoomController@all'); // 获取所有数据
    Route::get('{id}', 'DeviceRoomController@show'); // 获取指定id
    Route::post('', 'DeviceRoomController@store'); // 新增
    Route::put('{id}', 'DeviceRoomController@update'); // 更新
    Route::delete('{id}', 'DeviceRoomController@destroy'); // 删除
});
// 产品 /index.php/api/product
Route::prefix('/product')->group(function(){
    Route::get('', 'ProductController@index'); // 获取列表
    Route::get('{id}', 'ProductController@show'); // 获取指定id
    Route::post('', 'ProductController@store'); // 新增
    Route::put('{id}', 'ProductController@update'); // 更新
    Route::delete('{id}', 'ProductController@destroy'); // 删除
});
// 产品字段 /index.php/api/product_field
Route::prefix('/product_field')->group(function(){
    Route::get('', 'ProductFieldController@index'); // 获取列表
    Route::get('all', 'ProductFieldController@all'); // 获取所有数据
    Route::get('{id}', 'ProductFieldController@show'); // 获取指定id
    Route::post('', 'ProductFieldController@store'); // 新增
    Route::put('{id}', 'ProductFieldController@update'); // 更新
    Route::delete('{id}', 'ProductFieldController@destroy'); // 删除
});
// 设备 /index.php/api/device
Route::prefix('/device')->group(function(){
    Route::get('', 'DeviceController@index'); // 获取列表
    Route::get('{id}', 'DeviceController@show'); // 获取指定id
    Route::post('', 'DeviceController@store'); // 新增
    Route::put('{id}', 'DeviceController@update'); // 更新
    Route::delete('{id}', 'DeviceController@destroy'); // 删除
});
// 设备字段 /index.php/api/device_field
Route::prefix('/device_field')->group(function(){
    Route::get('', 'DeviceFieldController@index'); // 获取列表
    Route::get('all', 'DeviceFieldController@all'); // 获取所有数据
    Route::get('{id}', 'DeviceFieldController@show'); // 获取指定id
    Route::post('', 'DeviceFieldController@store'); // 新增
    Route::put('{id}', 'DeviceFieldController@update'); // 更新
    Route::delete('{id}', 'DeviceFieldController@destroy'); // 删除
});