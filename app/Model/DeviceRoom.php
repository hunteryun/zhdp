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
        $this->user_id          = $request->input('user_id');
        $this->device_region_id = $request->input('device_region_id');
        $this->name             = $request->input('name');
        $this->desc             = $request->input('desc');
        $this->token            = str_random(60); // token 禁止更新
        return $this->save();
    }
    // 更新设备房间
    public function updateDeviceRoom($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceRoomInfo                   = $this->getFind($id);
        $deviceRoomInfo->user_id          = $request->input('user_id');
        $deviceRoomInfo->device_region_id = $request->input('device_region_id');
        $deviceRoomInfo->name             = $request->input('name');
        $deviceRoomInfo->desc             = $request->input('desc');
        return $deviceRoomInfo->save();
    }
    // 删除设备房间
    public function deleteDeviceRoom($id){
        $deviceRoomInfo = $this->getFind($id);
        return $deviceRoomInfo->delete();
    }
}
