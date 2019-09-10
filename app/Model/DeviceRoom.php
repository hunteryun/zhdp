<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 设备房间
class DeviceRoom extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_room';
    // 关联查询所属区域
    public function device_region()
    {
         return $this->belongsTo(DeviceRegion::class);
    }
    // 关联查询所属作物
    public function crop_class()
    {
         return $this->belongsTo(CropClass::class);
    }
    // 关联查询房间下的设备
    public function device()
    {
         return $this->hasMany(Device::class);
    }
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(empty($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
}
