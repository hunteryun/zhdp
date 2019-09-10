<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 设备区域
class DeviceRegion extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_region';
    // 关联区域下的房间
    public function device_room()
    {
         return $this->hasMany(DeviceRoom::class);
    }
}
