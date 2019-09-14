<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备事件日志
class DeviceEventLog extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_event_log';
}
