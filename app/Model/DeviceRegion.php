<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备区域
class DeviceRegion extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_region';
    // 新增设备区域
    public function addDeviceRegion($deviceRegionInfo = []){
        $this->name     = $deviceRegionInfo['name'];
        $this->user_id   = $deviceRegionInfo['user_id'];
        return $this->save();
    }
    // 更新设备区域
    public function updateDeviceRegion($deviceRegionInfo = [], $updateDeviceRegion = []){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceRegionInfo->name         = $updateDeviceRegion['name'];
        $deviceRegionInfo->user_id                  = $updateDeviceRegion['user_id'];
        return $deviceRegionInfo->save();
    }
    // 删除设备区域
    public function deleteDeviceRegion($deviceRegionInfo = []){
        return $deviceRegionInfo->delete();
    }
}
