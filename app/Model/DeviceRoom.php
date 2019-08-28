<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 设备房间
class DeviceRoom extends Model
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
        try{
            return $this->findOrFail($id);
        }catch(\Exception $exception){
            throw new IdNotFound('设备房间Id未找到');
        }
    }
    // 新增设备房间
    public function addDeviceRoom($request){
        $this->name         = $request->input('name');
        $this->user_id      = $request->input('user_id');
        return $this->save();
    }
    // 更新设备房间
    public function updateDeviceRoom($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceRoomInfo               = $this->getFind($id);
        $deviceRoomInfo->name         = $request->input('name');
        $deviceRoomInfo->user_id      = $request->input('user_id');
        return $deviceRoomInfo->save();
    }
    // 删除设备房间
    public function deleteDeviceRoom($id){
        $deviceRoomInfo = $this->getFind($id);
        return $deviceRoomInfo->delete();
    }
}
