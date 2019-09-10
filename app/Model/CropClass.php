<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 作物分类
class CropClass extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_class';
    // 关联分类下的分类
    public function crop_class_child()
    {
         return $this->hasMany(CropClass::class, 'pid', 'id');
    }
    // 关联作物所属分类
    public function crop_class_parent()
    {
         return $this->belongsTo(CropClass::class, 'pid', 'id');
    }
}
