<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备区域
class DeviceRegion extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_region';
    // 获取分页
    public function getPaginate($request){
        return $this->paginate($request->input('limit'))->toArray();
    }
    // 获取所有
    public function getAll($request){
        return $this->all();
    }
    // 获取单个
    public function getFind($id){
        return $this->findOrFail($id);
    }
    // 新增设备区域
    public function addDeviceRegion($deviceRegionInfo = []){
        $this->name     = $deviceRegionInfo['name'];
        $this->user_id   = $deviceRegionInfo['user_id'];
        return $this->save();
    }
    // 更新设备区域
    public function updateDeviceRegion($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceRegionInfo               = $this->findOrFail($id);
        $deviceRegionInfo->name         = $request->input('name');
        $deviceRegionInfo->user_id      = $request->input('user_id');
        return $deviceRegionInfo->save();
    }
    // 删除设备区域
    public function deleteDeviceRegion($deviceRegionInfo = []){
        return $deviceRegionInfo->delete();
    }
}
