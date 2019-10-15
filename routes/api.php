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
    Route::post('reg', 'Api\\User\\RegController@index'); // 注册
    Route::post('login', 'Api\\User\\LoginController@index'); // 登录
    Route::get('out', 'Api\\User\\LoginController@out'); // 退出
    Route::get('my', 'Api\\User\\UserController@get_my')->middleware('user.token'); // 用户自己
    Route::put('my/{id}', 'Api\\User\\UserController@update_my')->where('id', '[0-9]+')->middleware('user.token'); // 用户自己

    // 字段类型 /index.php/api/field_type
    Route::prefix('/field_type')->group(function(){
        Route::get('all', 'Api\\User\\FieldTypeController@all')->middleware('user.token'); // 获取所有数据
    });
    // 产品 /index.php/api/product
    Route::prefix('/product')->group(function(){
        Route::get('all', 'Api\\User\\ProductController@all')->middleware('user.token'); // 获取所有数据
        // 产品字段 /index.php/api/product_field
        Route::prefix('/product_field')->group(function(){
            Route::get('all', 'Api\\User\\ProductFieldController@all')->middleware('user.token'); // 获取所有数据
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
    // 作物追溯
    Route::prefix('/crop_traceability')->group(function(){
        Route::get('', 'Api\\User\\CropTraceabilityController@index')->middleware('user.token'); // 作物追溯列表
        Route::post('', 'Api\\User\\CropTraceabilityController@store')->middleware('user.token'); // 添加作物追溯列表
        Route::put('{id}', 'Api\\User\\CropTraceabilityController@update')->middleware('user.token'); // 更新作物追溯列表
        Route::delete('{id}', 'Api\\User\\CropTraceabilityController@destroy')->middleware('user.token'); // 删除作物追溯列表
        // 
        // 作物追溯日志
        Route::prefix('/crop_traceability_event_log')->group(function(){
            Route::get('all/{id}', 'Api\\User\\CropTraceabilityEventLogController@all')->where('id', '[0-9]+')->middleware('user.token'); // 作物追溯事件列表
            Route::post('', 'Api\\User\\CropTraceabilityEventLogController@store')->middleware('user.token'); // 添加作物追溯日志
        });
        // 作物收获日志
        Route::prefix('/crop_traceability_batch')->group(function(){
            Route::get('all/{id}', 'Api\\User\\CropTraceabilityBatchController@all')->where('id', '[0-9]+')->middleware('user.token'); // 作物收获记录
            Route::post('', 'Api\\User\\CropTraceabilityBatchController@store')->middleware('user.token'); // 添加作物收获记录
            // 
            Route::get('pending_review', 'Api\\User\\CropTraceabilityBatchController@pending_review')->middleware('user.token'); // 作物追溯待审核列表
            Route::get('audited', 'Api\\User\\CropTraceabilityBatchController@audited')->middleware('user.token'); // 作物追溯已审核列表
        });
        // 二维码作物追溯详情获取收获批次[无需验证用户身份]
        Route::get('qr_code_crop_traceability_info/{token}', 'Api\\User\\CropTraceabilityController@qr_code_crop_traceability_info')->where('token', '[0-9a-zA-Z]{60}'); //

    });
    // 作物分类
    Route::prefix('/crop_class')->group(function(){
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

        // 获取硬件数据[获取的时候只返回0或1] 因为用户token每次登录会被改变
        // 需要获取数据的都是继电器
        Route::get('{device_token}/{field}', 'Api\\User\\DeviceController@getDeviceField')->where('device_token', '[0-9a-zA-Z]{60}'); // 指定token获取
        // 上传硬件数据
        // 上传硬件数据的是传感器
        Route::post('{device_token}', 'Api\\User\\DeviceController@updateDeviceField')->where('device_token', '[0-9a-zA-Z]{60}'); // 指定token更新(web界面操作)
        // 上传图片
        Route::post('{device_token}/{field}', 'Api\\User\\DeviceController@updateDeviceImg')->where('device_token', '[0-9a-zA-Z]{60}'); // 指定token更新(web界面操作)


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
        Route::post('big_screen', 'Api\\User\\DataAnalysisController@big_screen')->middleware('user.token'); // 数据大屏
    });
    // 病虫害与天气预警
    Route::prefix('/pest_warning')->group(function(){
        // 病虫害与天气预警日志
        Route::prefix('/pest_warning_log')->group(function(){
            Route::get('', 'Api\\User\\PestWarningLogController@index')->middleware('user.token'); // 病虫害与天气预警日志列表
            Route::get('{id}', 'Api\\User\\PestWarningLogController@show')->where('id', '[0-9]+')->middleware('user.token'); // 获取指定id房间
        });
    });
    // 文章分类
    Route::prefix('/article_class')->group(function(){
        Route::get('all', 'Api\\User\\ArticleClassController@all')->middleware('user.token'); // 所有文章分类列表
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
    // 登录通知表
    Route::prefix('/login_notice')->group(function(){
        // 即时通知
        Route::prefix('/immediate_login_notice')->group(function(){
            Route::get('', 'Api\\User\\LoginNoticeController@index')->middleware('user.token'); // 获取所有即时通知(index页面调用)
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
});
// 管理员
Route::prefix('/admin')->group(function(){
    Route::post('login', 'Api\\Admin\\LoginController@index'); // 登录
    Route::get('out', 'Api\\Admin\\LoginController@out'); // 退出
    Route::get('my', 'Api\\Admin\\AdminController@get_my')->middleware('admin.token'); // 用户自己
    Route::put('my/{id}', 'Api\\Admin\\AdminController@update_my')->where('id', '[0-9]+')->middleware('admin.token'); // 用户自己

    // 字段类型 /index.php/api/field_type
    Route::prefix('/field_type')->group(function(){
        Route::get('', 'Api\\Admin\\FieldTypeController@index')->middleware('admin.token'); // 获取列表
        Route::get('all', 'Api\\Admin\\FieldTypeController@all')->middleware('admin.token'); // 获取所有数据
        Route::get('{id}', 'Api\\Admin\\FieldTypeController@show')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\FieldTypeController@store')->middleware('admin.token'); // 新增
        Route::put('{id}', 'Api\\Admin\\FieldTypeController@update')->middleware('admin.token'); // 更新
        Route::delete('{id}', 'Api\\Admin\\FieldTypeController@destroy')->middleware('admin.token'); // 删除
    });
    // 产品 /index.php/api/product
    Route::prefix('/product')->group(function(){
        Route::get('', 'Api\\Admin\\ProductController@index')->middleware('admin.token'); // 获取列表
        Route::get('all', 'Api\\Admin\\ProductController@all')->middleware('admin.token'); // 获取所有数据
        Route::get('{id}', 'Api\\Admin\\ProductController@show')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\ProductController@store')->middleware('admin.token'); // 新增
        Route::put('{id}', 'Api\\Admin\\ProductController@update')->middleware('admin.token'); // 更新
        Route::delete('{id}', 'Api\\Admin\\ProductController@destroy')->middleware('admin.token'); // 删除
        // 产品字段 /index.php/api/product_field
        Route::prefix('/product_field')->group(function(){
            Route::get('all', 'Api\\Admin\\ProductFieldController@all')->middleware('admin.token'); // 获取所有数据
            Route::post('', 'Api\\Admin\\ProductFieldController@store')->middleware('admin.token'); // 新增
            Route::put('{id}', 'Api\\Admin\\ProductFieldController@update')->middleware('admin.token'); // 更新
            Route::delete('{id}', 'Api\\Admin\\ProductFieldController@destroy')->middleware('admin.token'); // 删除
        });
    });
    // 作物分类
    Route::prefix('/crop_class')->group(function(){
        Route::get('', 'Api\\Admin\\CropClassController@index')->middleware('admin.token'); // 作物分类列表
        Route::post('', 'Api\\Admin\\CropClassController@store')->middleware('admin.token'); // 添加作物分类列表
        Route::put('{id}', 'Api\\Admin\\CropClassController@update')->middleware('admin.token'); // 更新作物分类列表
        Route::delete('{id}', 'Api\\Admin\\CropClassController@destroy')->middleware('admin.token'); // 删除作物分类列表

        Route::get('all_child', 'Api\\Admin\\CropClassController@all_child')->middleware('admin.token'); // 所有作物分类(子分类)

        Route::get('top', 'Api\\Admin\\CropClassController@topAll')->middleware('admin.token'); // 所有顶级作物分类列表
        Route::get('top/{id}', 'Api\\Admin\\CropClassController@topIdAll')->middleware('admin.token'); // 获取指定id下的作物种类
    });
    // 作物追溯
    Route::prefix('/crop_traceability')->group(function(){
        // 作物收获日志
        Route::prefix('/crop_traceability_batch')->group(function(){
            Route::get('pending_review', 'Api\\Admin\\CropTraceabilityBatchController@pending_review')->middleware('admin.token'); // 作物追溯待审核列表
            Route::put('review/{id}', 'Api\\Admin\\CropTraceabilityBatchController@review')->where('id', '[0-9]+')->middleware('admin.token'); // 作物追溯审核(可以审核通过和审核不用过)
            Route::get('audited', 'Api\\Admin\\CropTraceabilityBatchController@audited')->middleware('admin.token'); // 作物追溯已审核列表
        });
    });
    // 数据分析
    Route::prefix('/data_analysis')->group(function(){
        // 这里的post是为了方便带上参数
        // Route::post('visualization', 'Api\\Admin\\DataAnalysisController@visualization')->middleware('admin.token'); // 数据可视化
        Route::post('big_screen', 'Api\\Admin\\DataAnalysisController@big_screen')->middleware('admin.token'); // 数据大屏
    });
    // 病虫害与天气预警
    Route::prefix('/pest_warning')->group(function(){
        Route::get('', 'Api\\Admin\\PestWarningController@index')->middleware('admin.token'); // 病虫害与天气预警列表
        Route::post('', 'Api\\Admin\\PestWarningController@store')->middleware('admin.token'); // 添加病虫害与天气预警列表
        Route::get('{id}', 'Api\\Admin\\PestWarningController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id房间
        Route::put('{id}', 'Api\\Admin\\PestWarningController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新病虫害与天气预警列表
        Route::delete('{id}', 'Api\\Admin\\PestWarningController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除病虫害与天气预警列表
    });
    // 文章分类
    Route::prefix('/article_class')->group(function(){
        Route::get('', 'Api\\Admin\\ArticleClassController@index')->middleware('admin.token'); // 文章分类列表
        Route::get('all', 'Api\\Admin\\ArticleClassController@all')->middleware('admin.token'); // 所有文章分类列表
        Route::post('', 'Api\\Admin\\ArticleClassController@store')->middleware('admin.token'); // 添加文章分类列表
        Route::put('{id}', 'Api\\Admin\\ArticleClassController@update')->middleware('admin.token'); // 更新文章分类列表
        Route::delete('{id}', 'Api\\Admin\\ArticleClassController@destroy')->middleware('admin.token'); // 删除文章分类列表
    });
    // 文章
    Route::prefix('/article')->group(function(){
        Route::get('', 'Api\\Admin\\ArticleController@index')->middleware('admin.token'); // 文章列表
        Route::get('{id}', 'Api\\Admin\\ArticleController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\ArticleController@store')->middleware('admin.token'); // 添加文章列表
        Route::put('{id}', 'Api\\Admin\\ArticleController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新文章列表
        Route::delete('{id}', 'Api\\Admin\\ArticleController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除文章列表
    });
    // 文章评论
    Route::prefix('/article_comment')->group(function(){
        Route::get('', 'Api\\Admin\\ArticleCommentController@index')->middleware('admin.token'); // 文章评论
    });
    // 用户表
    Route::prefix('/user')->group(function(){
        Route::get('', 'Api\\Admin\\UserController@index')->middleware('admin.token'); // 用户
        Route::get('{id}', 'Api\\Admin\\UserController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\UserController@store')->middleware('admin.token'); // 添加用户
        Route::put('{id}', 'Api\\Admin\\UserController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新用户
        Route::delete('{id}', 'Api\\Admin\\UserController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除用户

    });
    // 管理员表
    Route::prefix('/admin')->group(function(){
        Route::get('', 'Api\\Admin\\AdminController@index')->middleware('admin.token'); // 管理员
        Route::get('{id}', 'Api\\Admin\\AdminController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\AdminController@store')->middleware('admin.token'); // 添加管理员
        Route::put('{id}', 'Api\\Admin\\AdminController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新管理员
        Route::delete('{id}', 'Api\\Admin\\AdminController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除管理员
    });
    // 登录通知表
    Route::prefix('/login_notice')->group(function(){
        Route::get('', 'Api\\Admin\\LoginNoticeController@index')->middleware('admin.token'); // 登录通知
        Route::get('{id}', 'Api\\Admin\\LoginNoticeController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
        Route::post('', 'Api\\Admin\\LoginNoticeController@store')->middleware('admin.token'); // 添加登录通知
        Route::put('{id}', 'Api\\Admin\\LoginNoticeController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新登录通知
        Route::delete('{id}', 'Api\\Admin\\LoginNoticeController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除登录通知、
    });
    // 系统设置
    Route::prefix('/system_settings')->group(function(){
        // 系统设置组
        Route::prefix('/system_settings_group')->group(function(){
            Route::get('', 'Api\\Admin\\SystemSettingsGroupController@index')->middleware('admin.token'); // 获取列表
            Route::get('all', 'Api\\Admin\\SystemSettingsGroupController@all')->middleware('admin.token'); // 获取所有数据
            Route::get('{id}', 'Api\\Admin\\SystemSettingsGroupController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
            Route::post('', 'Api\\Admin\\SystemSettingsGroupController@store')->middleware('admin.token'); // 新增
            Route::put('{id}', 'Api\\Admin\\SystemSettingsGroupController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新
            Route::delete('{id}', 'Api\\Admin\\SystemSettingsGroupController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除
        });
        // 系统设置字段
        Route::prefix('/system_settings_group_field')->group(function(){
            Route::get('', 'Api\\Admin\\SystemSettingsGroupFieldController@index')->middleware('admin.token'); // 获取列表
            Route::get('{id}', 'Api\\Admin\\SystemSettingsGroupFieldController@show')->where('id', '[0-9]+')->middleware('admin.token'); // 获取指定id
            Route::post('', 'Api\\Admin\\SystemSettingsGroupFieldController@store')->middleware('admin.token'); // 新增
            Route::put('{id}', 'Api\\Admin\\SystemSettingsGroupFieldController@update')->where('id', '[0-9]+')->middleware('admin.token'); // 更新
            Route::delete('{id}', 'Api\\Admin\\SystemSettingsGroupFieldController@destroy')->where('id', '[0-9]+')->middleware('admin.token'); // 删除
        });
    });
});
// 兜底路由
Route::fallback(function () {
    throw new App\Exceptions\NotFoundUrl();
});