<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 设备字段
class DeviceField extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'device_field';
    // 关联查询设备字段下的事件
    public function device_event()
    {
         return $this->hasMany(DeviceEvent::class);
    }
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
}
