<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 产品
class Product extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'product';
    // 关联关系
    // 关联产品下的字段
    public function product_field()
    {
         return $this->hasMany(ProductField::class);
    }
    // 自动填充
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
}
