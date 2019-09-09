<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 设备字段
class DeviceField extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_field';
    // 隐藏指定字段
    // protected $hidden = ['updated_at'];
    // 只可以显示的字段
    // protected $visible = ['updated_at'];
     // 关联获取字段类型
     public function field_type()
     {
          return $this->belongsTo(FieldType::class);
     }
    // 设置默认值 length 字段
    public function setLengthAttribute($value)
    {
        if(empty($value)){
            $this->attributes['length'] = 0;
        }else{
            $this->attributes['length'] = $value;
        }
    }
    // 设置默认值 common_field 字段
    public function setCommonFieldAttribute($value)
    {
        if(empty($value)){
            $this->attributes['common_field'] = '';
        }else{
            $this->attributes['common_field'] = $value;
        }
    }
    // 设置默认值 common_field_sort 字段
    public function setCommonFieldSortAttribute($value)
    {
        if(empty($value)){
            $this->attributes['common_field_sort'] = 0;
        }else{
            $this->attributes['common_field_sort'] = $value;
        }
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
    // 设置默认值 sort 字段
    public function setSortAttribute($value)
    {
        if(empty($value)){
            $this->attributes['sort'] = 0;
        }else{
            $this->attributes['sort'] = $value;
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
            throw new IdNotFound('设备字段Id未找到');
        }
    }
    // 新增设备字段
    public function addDeviceField($request){
        $this->device_id    = $request->input('device_id');
        $this->name          = $request->input('name');
        $this->field         = $request->input('field');
        $this->field_type_id = $request->input('field_type_id');
        $this->value         = $request->input('value');
        $this->length        = $request->input('length');
        $this->common_field  = $request->input('common_field');
        $this->common_field_sort  = $request->input('common_field_sort');
        $this->desc          = $request->input('desc');
        $this->sort          = $request->input('sort');
        return $this->save();
    }
    // 更新设备字段
    public function updateDeviceField($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $deviceFieldInfo                = $this->getFind($id);
        $deviceFieldInfo->device_id    = $request->input('device_id');
        $deviceFieldInfo->name          = $request->input('name');
        $deviceFieldInfo->field         = $request->input('field');
        $deviceFieldInfo->field_type_id = $request->input('field_type_id');
        $deviceFieldInfo->value         = $request->input('value');
        $deviceFieldInfo->length        = $request->input('length');
        $deviceFieldInfo->common_field  = $request->input('common_field');
        $deviceFieldInfo->common_field_sort  = $request->input('common_field_sort');
        $deviceFieldInfo->desc          = $request->input('desc');
        $deviceFieldInfo->sort          = $request->input('sort');
        return $deviceFieldInfo->save();
    }
    // 删除设备字段
    public function deleteDeviceField($id){
        $deviceFieldInfo = $this->getFind($id);
        return $deviceFieldInfo->delete();
    }
}
