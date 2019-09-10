<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备字段
class DeviceFieldLog extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_field_log';
     // 关联获取字段类型
     public function field_type()
     {
          return $this->belongsTo(FieldType::class);
     }
     // 关联查询所属设备
    public function device()
    {
         return $this->belongsTo(Device::class);
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
}
