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
    Route::get('{id}', 'UserController@show')->where('id', '[0-9]+'); // 获取指定id
    Route::post('', 'UserController@store'); // 新增
    Route::put('{id}', 'UserController@update'); // 更新
    Route::delete('{id}', 'UserController@destroy'); // 删除
});