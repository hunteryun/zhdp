<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 产品字段
class ProductField extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'product_field';
    // 关联获取字段类型
    public function field_type()
    {
         return $this->belongsTo(FieldType::class);
    }
    // 设置默认值 length 字段
    public function setLengthAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['length'] = 0;
        }else{
            $this->attributes['length'] = $value;
        }
    }
    // 设置默认值 default 字段
    public function setDefaultAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['default'] = '';
        }else{
            $this->attributes['default'] = $value;
        }
    }
    // 设置默认值 common_field 字段
    public function setCommonFieldAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['common_field'] = '';
        }else{
            $this->attributes['common_field'] = $value;
        }
    }
    // 设置默认值 common_field_sort 字段
    public function setCommonFieldSortAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['common_field_sort'] = 0;
        }else{
            $this->attributes['common_field_sort'] = $value;
        }
    }
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
    // 设置默认值 sort 字段
    public function setSortAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['sort'] = 0;
        }else{
            $this->attributes['sort'] = $value;
        }
    }
}
