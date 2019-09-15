<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 病虫害预警
class PestWarning extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'pest_warning';
    // 设置默认值 start_time 字段
    public function setStartTimeAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['start_time'] = '';
        }else{
            $this->attributes['start_time'] = $value;
        }
    }
   // 设置默认值 end_time 字段
   public function setEndTimeAttribute($value)
   {
       if(is_null($value)){
           $this->attributes['end_time'] = '';
       }else{
           $this->attributes['end_time'] = $value;
       }
   }
}
