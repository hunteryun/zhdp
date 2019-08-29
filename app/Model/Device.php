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
    // 关联关系
    /**
     * 获取博客文章的评论
     */
    public function device_field()
    {
         return $this->hasMany(DeviceField::class);
    }
    // 自动填充
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(empty($value)){
            $this->attributes['desc'] = '';
        }
    }
    // 获取分页
    public function getPaginate($request){
        // return $this->with('device_field')->paginate($request->input('limit'))->toArray();
        return $this->paginate($request->input('limit'))->toArray();
    }
    // 获取所有
    public function getAll($request){
        return $this->all();
    }
    // 获取单个
    public function getFind($id){
        try{
            // return $this->with('device_field')->findOrFail($id);
            return $this->findOrFail($id);
        }catch(\Exception $exception){
            throw new IdNotFound('设备Id未找到');
        }
    }
    // 新增设备
    public function addDevice($request){
        $this->user_id          = $request->input('user_id');
        $this->product_id       = $request->input('product_id');
        $this->device_room_id   = $request->input('device_room_id');
        $this->name             = $request->input('name');
        $this->desc             = $request->input('desc');
        $this->token            = getOnlyToken_60();
        return $this->save();
    }
    // 更新设备
    public function updateDevice($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceInfo            = $this->getFind($id);
        $deviceInfo->user_id          = $request->input('user_id');
        $deviceInfo->product_id       = $request->input('product_id');
        $deviceInfo->device_room_id   = $request->input('device_room_id');
        $deviceInfo->name             = $request->input('name');
        $deviceInfo->desc             = $request->input('desc');
        return $deviceInfo->save();
    }
    // 删除设备
    public function deleteDevice($id){
        $deviceInfo = $this->getFind($id);
        return $deviceInfo->delete();
    }

}
