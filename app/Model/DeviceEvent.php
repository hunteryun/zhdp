<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备事件
class DeviceEvent extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_event';
    // 关联查询触发设备
    public function device()
    {
         return $this->belongsTo(Device::class);
    }
    // 关联查询触发字段
    public function device_field()
    {
         return $this->belongsTo(DeviceField::class);
    }
    // 关联查询响应设备
    public function associated_device()
    {
         return $this->belongsTo(Device::class, "associated_device_id");
    }
    // 关联查询响应字段
    public function associated_device_field()
    {
         return $this->belongsTo(DeviceField::class, "associated_device_field_id");
    }
}
