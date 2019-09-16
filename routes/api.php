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
        // 获取硬件数据
        Route::get('{token}', 'Api\\User\\DeviceController@getDeviceField')->where('token', '[0-9a-zA-Z]{60}')->middleware('user.token'); // 指定token获取
        // 上传硬件数据
        Route::put('{token}', 'Api\\User\\DeviceController@updateDeviceField')->where('token', '[0-9a-zA-Z]{60}')->middleware('user.token'); // 指定token更新(web界面操作)
        // 设备字段 /index.php/api/device_field
        Route::prefix('/device_field')->group(function(){
            Route::get('all', 'Api\\User\\DeviceFieldController@all')->middleware('user.token'); // 获取所有数据
        });
        // 设备字段日志 /index.php/api/device_field_log
        Route::prefix('/device_field_log')->group(function(){
            Route::get('', 'Api\\User\\DeviceFieldLogController@index'); // 获取列表
        });
        // 事件
        Route::prefix('/device_event')->group(function(){
            Route::get('', 'Api\\User\\DeviceEventController@index')->middleware('user.token'); // 设备事件列表
            Route::get('all', 'Api\\User\\DeviceEventController@all')->middleware('user.token'); // 所有设备事件列表
            Route::post('', 'Api\\User\\DeviceEventController@store')->middleware('user.token'); // 添加设备事件列表
            Route::get('{id}', 'Api\\User\\DeviceEventController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定设备id的所有事件
            Route::put('{id}', 'Api\\User\\DeviceEventController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新设备事件列表
            Route::delete('{id}', 'Api\\User\\DeviceEventController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除设备事件列表
        });
        // 事件日志
        Route::prefix('/device_event_log')->group(function(){
            Route::get('', 'Api\\User\\DeviceEventLogController@index')->middleware('user.token'); // 设备事件日志列表
            Route::get('all', 'Api\\User\\DeviceEventLogController@all')->middleware('user.token'); // 所有设备事件日志列表
            Route::post('', 'Api\\User\\DeviceEventLogController@store')->middleware('user.token'); // 添加设备事件日志列表
            Route::get('{id}', 'Api\\User\\DeviceEventLogController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定设备id的所有事件日志
            Route::put('{id}', 'Api\\User\\DeviceEventLogController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新设备事件日志列表
            Route::delete('{id}', 'Api\\User\\DeviceEventLogController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除设备事件日志列表
        });
    });
    // 数据分析
    Route::prefix('/data_analysis')->group(function(){
        // 这里的post是为了方便带上参数
        Route::post('visualization', 'Api\\User\\DataAnalysisController@visualization')->middleware('user.token'); // 数据可视化
        Route::post('big_screen', 'Api\\User\\DeviceRoomController@big_screen')->middleware('user.token'); // 数据大屏
    });
    // 病虫害与天气预警
    Route::prefix('/pest_warning')->group(function(){
        Route::get('', 'Api\\User\\PestWarningController@index')->middleware('user.token'); // 病虫害与天气预警列表
        Route::post('', 'Api\\User\\PestWarningController@store')->middleware('user.token'); // 添加病虫害与天气预警列表
        Route::get('{id}', 'Api\\User\\PestWarningController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id房间
        Route::put('{id}', 'Api\\User\\PestWarningController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新病虫害与天气预警列表
        Route::delete('{id}', 'Api\\User\\PestWarningController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除病虫害与天气预警列表
        // 病虫害与天气预警日志
        Route::prefix('/pest_warning_log')->group(function(){
            Route::get('', 'Api\\User\\PestWarningLogController@index')->middleware('user.token'); // 病虫害与天气预警日志列表
            Route::get('{id}', 'Api\\User\\PestWarningLogController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id房间
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
        Route::put('{id}', 'Api\\User\\ArticleViewController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新文章浏览记录
        Route::delete('{id}', 'Api\\User\\ArticleViewController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除文章浏览记录
        Route::prefix('/my')->group(function(){
            Route::get('', 'Api\\User\\ArticleViewController@my')->middleware('user.token'); // 获取自己收藏的文章
        });
    });
    // 文章收藏表
    Route::prefix('/article_collection')->group(function(){
        Route::get('', 'Api\\User\\ArticleCollectionController@index')->middleware('user.token'); // 文章收藏
        Route::get('{article_id}', 'Api\\User\\ArticleCollectionController@show')->where('article_id', '[0-9]+')->middleware('user.token'); // 获取指定id是否收藏
        Route::post('', 'Api\\User\\ArticleCollectionController@store')->middleware('user.token'); // 添加文章收藏
        Route::delete('{id}', 'Api\\User\\ArticleCollectionController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除文章收藏
        Route::prefix('/my')->group(function(){
            Route::get('', 'Api\\User\\ArticleCollectionController@my')->middleware('user.token'); // 获取自己收藏的文章
        });
    });
    // 用户表
    Route::prefix('/user')->group(function(){
        Route::get('', 'Api\\User\\UserController@index')->middleware('user.token'); // 用户
        Route::get('{id}', 'Api\\User\\UserController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\UserController@store')->middleware('user.token'); // 添加用户
        Route::put('{id}', 'Api\\User\\UserController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新用户
        Route::delete('{id}', 'Api\\User\\UserController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除用户
    });
    // 管理员表
    Route::prefix('/admin')->group(function(){
        Route::get('', 'Api\\User\\AdminController@index')->middleware('user.token'); // 管理员
        Route::get('{id}', 'Api\\User\\AdminController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\AdminController@store')->middleware('user.token'); // 添加管理员
        Route::put('{id}', 'Api\\User\\AdminController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新管理员
        Route::delete('{id}', 'Api\\User\\AdminController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除管理员
    });
    // 登录通知表
    Route::prefix('/login_notice')->group(function(){
        Route::get('', 'Api\\User\\LoginNoticeController@index')->middleware('user.token'); // 登录通知
        Route::get('every_day', 'Api\\User\\LoginNoticeController@every_day')->middleware('user.token'); // 获取每次登录都要提示的信息
        Route::get('{id}', 'Api\\User\\LoginNoticeController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
        Route::post('', 'Api\\User\\LoginNoticeController@store')->middleware('user.token'); // 添加登录通知
        Route::put('{id}', 'Api\\User\\LoginNoticeController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新登录通知
        Route::delete('{id}', 'Api\\User\\LoginNoticeController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除登录通知、
        // 即时通知
        Route::prefix('/immediate_login_notice')->group(function(){
            Route::get('', 'Api\\User\\LoginNoticeController@every_day')->middleware('user.token'); // 获取即时通知分页
            Route::get('every_day_all', 'Api\\User\\LoginNoticeController@every_day_all')->middleware('user.token'); // 获取所有即时通知(index页面调用)
        });
        Route::prefix('/login_notice_log')->group(function(){
            Route::get('', 'Api\\User\\LoginNoticeLogController@index')->middleware('user.token'); // 获取历史通知(每个人查看记录的那种)
            Route::get('{id}', 'Api\\User\\LoginNoticeLogController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
            Route::get('unread_all', 'Api\\User\\LoginNoticeLogController@unread_all')->middleware('user.token'); // 获取所有未读通知(index页面调用)(获取后则变为已读)
        });
    });
    // 系统消息
    Route::prefix('/system_msg')->group(function(){
        Route::get('', 'Api\\User\\SystemMsgController@index')->middleware('user.token'); // 系统消息列表
        Route::get('{id}', 'Api\\User\\SystemMsgController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id(并更新读取状态)
    });
    // 系统设置
    Route::prefix('/system_settings')->group(function(){
        // 系统设置组
        Route::prefix('/system_settings_group')->group(function(){
            Route::get('', 'Api\\User\\SystemSettingsGroupController@index')->middleware('user.token'); // 获取列表
            Route::get('all', 'Api\\User\\SystemSettingsGroupController@all')->middleware('user.token'); // 获取所有数据
            Route::get('{id}', 'Api\\User\\SystemSettingsGroupController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
            Route::post('', 'Api\\User\\SystemSettingsGroupController@store')->middleware('user.token'); // 新增
            Route::put('{id}', 'Api\\User\\SystemSettingsGroupController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新
            Route::delete('{id}', 'Api\\User\\SystemSettingsGroupController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除
        });
        // 系统设置字段
        Route::prefix('/system_settings_group_field')->group(function(){
            Route::get('', 'Api\\User\\SystemSettingsGroupFieldController@index')->middleware('user.token'); // 获取列表
            Route::get('{id}', 'Api\\User\\SystemSettingsGroupFieldController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id
            Route::post('', 'Api\\User\\SystemSettingsGroupFieldController@store')->middleware('user.token'); // 新增
            Route::put('{id}', 'Api\\User\\SystemSettingsGroupFieldController@update')->where('id', '[0-9]+')->middleware('user.token'); // 更新
            Route::delete('{id}', 'Api\\User\\SystemSettingsGroupFieldController@destroy')->where('id', '[0-9]+')->middleware('user.token'); // 删除
        });
    });
});
// 兜底路由
Route::fallback(function () {
    throw new App\Exceptions\NotFoundUrl();
});