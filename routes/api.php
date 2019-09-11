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

        Route::get('all_child', 'Api\\User\\CropClassController@all_child')->middleware('user.token'); // 所有作物分类(子分类)

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
    // 文章分类
    Route::prefix('/article_class')->group(function(){
        Route::get('', 'Api\\User\\ArticleClassController@index')->middleware('user.token'); // 文章分类列表
        Route::get('all', 'Api\\User\\ArticleClassController@all')->middleware('user.token'); // 所有文章分类列表
        Route::post('', 'Api\\User\\ArticleClassController@store')->middleware('user.token'); // 添加文章分类列表
        Route::put('{id}', 'Api\\User\\ArticleClassController@update')->middleware('user.token'); // 更新文章分类列表
        Route::delete('{id}', 'Api\\User\\ArticleClassController@destroy')->middleware('user.token'); // 删除文章分类列表
    });
    // 文章
    Route::prefix('/article')->group(function(){
        Route::get('', 'Api\\User\\ArticleController@index')->middleware('user.token'); // 文章列表
        Route::get('{id}', 'Api\\User\\ArticleController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\ArticleController@store')->middleware('user.token'); // 添加文章列表
        Route::put('{id}', 'Api\\User\\ArticleController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新文章列表
        Route::delete('{id}', 'Api\\User\\ArticleController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除文章列表
        Route::prefix('/my')->group(function(){
            Route::get('', 'Api\\User\\ArticleController@my')->middleware('user.token'); // 获取自己的文章列表
        });
    });
    // 文章评论
    Route::prefix('/article_comment')->group(function(){
        Route::get('', 'Api\\User\\ArticleCommentController@index')->middleware('user.token'); // 文章评论
        Route::get('{id}', 'Api\\User\\ArticleCommentController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\ArticleCommentController@store')->middleware('user.token'); // 添加文章评论
        Route::put('{id}', 'Api\\User\\ArticleCommentController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新文章评论
        Route::delete('{id}', 'Api\\User\\ArticleCommentController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除文章评论
        Route::prefix('/my')->group(function(){
            Route::get('', 'Api\\User\\ArticleCommentController@my')->middleware('user.token'); // 获取自己的文章列表
        });
    });
    // 文章查看表
    Route::prefix('/article_view')->group(function(){
        Route::get('', 'Api\\User\\ArticleViewController@index')->middleware('user.token'); // 文章浏览记录
        Route::post('', 'Api\\User\\ArticleViewController@store')->middleware('user.token'); // 添加文章浏览记录
        Route::put('{id}', 'Api\\User\\ArticleViewController@update')->middleware('user.token'); // 更新文章浏览记录
        Route::delete('{id}', 'Api\\User\\ArticleViewController@destroy')->middleware('user.token'); // 删除文章浏览记录
    });
    // 文章收藏表
    Route::prefix('/article_collection')->group(function(){
        Route::get('', 'Api\\User\\ArticleCollectionController@index')->middleware('user.token'); // 文章收藏
        Route::get('{article_id}', 'Api\\User\\ArticleCollectionController@show')->middleware('user.token'); // 获取指定id是否收藏
        Route::post('', 'Api\\User\\ArticleCollectionController@store')->middleware('user.token'); // 添加文章收藏
        Route::delete('{id}', 'Api\\User\\ArticleCollectionController@destroy')->middleware('user.token'); // 删除文章收藏
    });
});
// 兜底路由
Route::fallback(function () {
    throw new App\Exceptions\NotFoundUrl();
});