<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 设备
class Device extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device';
    // 关联查询所属区域
    public function device_room()
    {
         return $this->belongsTo(DeviceRoom::class);
    }
    // 关联查询设备下的字段
    public function device_field()
    {
         return $this->hasMany(DeviceField::class);
    }
    // 关联查询设备下的字段日志
    public function device_field_log()
    {
         return $this->hasMany(DeviceFieldLog::class);
    }
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
}
