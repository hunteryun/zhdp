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
// 设备区域 /index.php/api/device_region
Route::prefix('/device_region')->group(function(){
    Route::get('', 'DeviceRegionController@index'); // 获取列表
    Route::get('all', 'DeviceRegionController@all'); // 获取所有数据
    Route::get('{id}', 'DeviceRegionController@show'); // 获取指定id
    Route::post('', 'DeviceRegionController@store'); // 新增
    Route::put('{id}', 'DeviceRegionController@update'); // 更新
    Route::delete('{id}', 'DeviceRegionController@destroy'); // 删除
});