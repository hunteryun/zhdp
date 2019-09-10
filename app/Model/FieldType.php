<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 字段类型
class FieldType extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'field_type';
    // 设置默认值 default字段
    public function setDefaultAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['default'] = '';
        }else{
            $this->attributes['default'] = $value;
        }
    }
    // 设置默认值 desc字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
}
