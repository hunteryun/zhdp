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
Route::view('/', 'user/login/index'); 
// // 用户 /index.php/user
Route::prefix('/user')->group(function(){
    Route::view('reg', 'user/reg/index'); // 用户注册
    Route::view('login', 'user/login/index'); // 用户登录
    Route::view('index', 'user/index/index'); // 首页

    Route::prefix('/my')->group(function(){
        Route::view('', 'user/my/index'); // 个人信息
    });
    // 区域管理
    Route::prefix('/device_region')->group(function(){
        Route::view('', 'user/device_region/index'); // 区域列表
        Route::view('add', 'user/device_region/add'); // 区域添加
        Route::view('edit', 'user/device_region/edit'); // 区域更新
    });
    // 房间管理
    Route::prefix('/device_room')->group(function(){
        Route::view('', 'user/device_room/index'); // 房间列表
        Route::view('add', 'user/device_room/add'); // 房间添加
        Route::view('edit', 'user/device_room/edit'); // 房间编辑
        Route::view('device', 'user/device_room/device/index'); // 设备字段管理
    });
    // 作物追溯管理
    Route::prefix('/crop_traceability')->group(function(){
        Route::view('', 'user/crop_traceability/index'); // 作物追溯列表
        Route::view('add', 'user/crop_traceability/add'); // 作物追溯添加
        Route::view('edit', 'user/crop_traceability/edit'); // 作物追溯编辑
        Route::view('info', 'user/crop_traceability/info'); // 作物追溯详情
        Route::view('crop_traceability_event_log/add', 'user/crop_traceability/crop_traceability_event_log/add'); // 作物追溯事件
        Route::view('crop_traceability_batch/add', 'user/crop_traceability/crop_traceability_batch/add'); // 作物追溯事件
        // 
        Route::view('qrcode_info', 'user/crop_traceability/qrcode_info/index'); // 作物追溯详情扫码获取的
    });
    // 设备管理
    Route::prefix('/device')->group(function(){
        Route::view('', 'user/device/index'); // 设备列表
        Route::view('add', 'user/device/add'); // 设备添加
        Route::view('edit', 'user/device/edit'); // 设备编辑
        Route::view('device_field', 'user/device/device_field/index'); // 设备字段管理
        // 设备字段日志管理
        Route::prefix('/device_field_log')->group(function(){
            Route::view('', 'user/device/device_field_log/index'); // 产品字段管理
            Route::view('add', 'user/device/device_field_log/add'); // 产品字段添加
            Route::view('edit', 'user/device/device_field_log/edit'); // 产品字段编辑
        });
        // 设备事件管理
        Route::prefix('/device_event')->group(function(){
            Route::view('', 'user/device/device_event/index'); // 设备事件管理
            Route::view('add', 'user/device/device_event/add'); // 设备事件添加
            Route::view('edit', 'user/device/device_event/edit'); // 设备事件编辑
        });
        // 设备事件日志管理
        Route::prefix('/device_event_log')->group(function(){
            Route::view('', 'user/device/device_event_log/index'); // 事件日志管理
        });
    });
    // 数据分析
    Route::prefix('/data_analysis')->group(function(){
        Route::view('visualization', 'user/data_analysis/visualization/index'); // 数据可视化
        Route::view('big_screen', 'user/data_analysis/big_screen/index'); // 数据大屏
    });
    // 病虫害预警管理
    Route::prefix('/pest_warning')->group(function(){
        Route::view('pest_warning_log', 'user/pest_warning/pest_warning_log/index'); // 病虫害预警日志管理(显示所有用户对于已发布事件的查看状态)
    });
    // 文章管理
    Route::prefix('/article')->group(function(){
        // 文章列表
        Route::view('', 'user/article/index'); // 文章列表
        Route::view('info', 'user/article/info'); // 文章详情
        Route::view('add', 'user/article/add'); // 文章添加
        // 我的文章
        Route::prefix('/my')->group(function(){
            Route::view('', 'user/article/my/index'); // 我的文章列表
            Route::view('info', 'user/article/info'); // 文章详情
            Route::view('edit', 'user/article/my/edit'); // 我的文章编辑
        });
        // 我的评论
        Route::prefix('/my_comment')->group(function(){
            Route::view('', 'user/article/my_comment/index'); // 我的评论列表
        });
        // 我的收藏
        Route::prefix('/my_collection')->group(function(){
            Route::view('', 'user/article/my_collection/index'); // 我的收藏列表
        });
        // 最近浏览
        Route::prefix('/my_view')->group(function(){
            Route::view('', 'user/article/my_view/index'); // 最近浏览列表
        });
    });
    // 登录通知表
    Route::prefix('/login_notice')->group(function(){
        // 
        Route::prefix('/immediate_login_notice')->group(function(){
            Route::view('', 'user/login_notice/immediate_login_notice/index'); //即时登录通知
            Route::view('info', 'user/login_notice/immediate_login_notice/info'); //即时登录通知详情
        });
        Route::prefix('/login_notice_log')->group(function(){
            Route::view('', 'user/login_notice/login_notice_log/index'); //登录通知记录
            Route::view('info', 'user/login_notice/login_notice_log/info'); //登录通知记录详情
        });
    });
    // 系统消息管理
    Route::prefix('/system_msg')->group(function(){
        Route::view('', 'user/system_msg/index'); // 系统消息列表
        Route::view('info', 'user/system_msg/info'); //系统消息列表详情
    });
});

// 管理员 /index.php/admin
Route::prefix('/admin')->group(function(){
    Route::view('login', 'admin/login/index'); // 用户登录
    Route::view('index', 'admin/index/index'); // 首页

    Route::prefix('/my')->group(function(){
        Route::view('', 'admin/my/index'); // 个人信息
    });

    // 字段类型管理
    Route::prefix('/field_type')->group(function(){
        Route::view('', 'admin/field_type/index'); // 字段类型列表
        Route::view('add', 'admin/field_type/add'); // 字段类型添加
        Route::view('edit', 'admin/field_type/edit'); // 字段类型编辑
    });
    // 产品管理
    Route::prefix('/product')->group(function(){
        Route::view('', 'admin/product/index'); // 产品列表
        Route::view('add', 'admin/product/add'); // 产品添加
        Route::view('edit', 'admin/product/edit'); // 产品编辑
        Route::prefix('/product_field')->group(function(){
            Route::view('', 'admin/product/product_field/index'); // 产品字段管理
            Route::view('add', 'admin/product/product_field/add'); // 产品字段添加
            Route::view('edit', 'admin/product/product_field/edit'); // 产品字段编辑
        });
    });
    // 作物分类管理
    Route::prefix('/crop_class')->group(function(){
        Route::view('', 'admin/crop_class/index'); // 作物分类列表
        Route::view('add', 'admin/crop_class/add'); // 作物分类添加
        Route::view('edit', 'admin/crop_class/edit'); // 作物分类编辑
    });
    
    // 数据分析
    Route::prefix('/data_analysis')->group(function(){
        Route::view('visualization', 'admin/data_analysis/visualization/index'); // 数据可视化
        Route::view('big_screen', 'admin/data_analysis/big_screen/index'); // 数据大屏
    });
    // 病虫害预警管理
    Route::prefix('/pest_warning')->group(function(){
        Route::view('', 'admin/pest_warning/index'); // 病虫害预警列表
        Route::view('add', 'admin/pest_warning/add'); // 病虫害预警添加
        Route::view('edit', 'admin/pest_warning/edit'); // 病虫害预警编辑
    });
    // 文章管理
    Route::prefix('/article')->group(function(){
        // 文章列表
        Route::view('', 'admin/article/index'); // 文章列表
        Route::view('info', 'admin/article/info'); // 文章详情
            // 文章分类管理
        Route::prefix('/class')->group(function(){
            Route::view('', 'admin/article/class/index'); // 文章分类列表
            Route::view('add', 'admin/article/class/add'); // 文章分类添加
            Route::view('edit', 'admin/article/class/edit'); // 文章分类编辑
        });
    });
    // 用户管理
    Route::prefix('/user')->group(function(){
        Route::view('', 'admin/user/index'); // 用户列表
        Route::view('add', 'admin/user/add'); // 用户添加
        Route::view('edit', 'admin/user/edit'); // 用户编辑
    });
    // 管理员管理
    Route::prefix('/admin')->group(function(){
        Route::view('', 'admin/admin/index'); // 管理员列表
        Route::view('add', 'admin/admin/add'); // 管理员添加
        Route::view('edit', 'admin/admin/edit'); // 管理员编辑
    });
    // 登录通知表
    Route::prefix('/login_notice')->group(function(){
        Route::view('', 'admin/login_notice/index'); // 登录通知列表
        Route::view('info', 'admin/login_notice/info'); // 登录通知详情
        Route::view('add', 'admin/login_notice/add'); // 登录通知添加
        Route::view('edit', 'admin/login_notice/edit'); // 登录通知编辑
    });
    // 系统设置组管理
    Route::prefix('/system_settings')->group(function(){
        Route::prefix('/system_settings_group')->group(function(){
            Route::view('', 'admin/system_settings/system_settings_group/index'); // 系统设置组列表
            Route::view('add', 'admin/system_settings/system_settings_group/add'); // 系统设置组添加
            Route::view('edit', 'admin/system_settings/system_settings_group/edit'); // 系统设置组编辑
        });
        // 系统设置管理
        Route::prefix('/system_settings_group_field')->group(function(){
            Route::view('', 'admin/system_settings/system_settings_group_field/index'); // 系统设置列表
            Route::view('add', 'admin/system_settings/system_settings_group_field/add'); // 系统设置添加
            Route::view('edit', 'admin/system_settings/system_settings_group_field/edit'); // 系统设置编辑
        });
    });
    
});

// 兜底路由
Route::fallback(function () {
    return view('404');
});

