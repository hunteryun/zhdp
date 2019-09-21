<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 作物追溯
class CropTraceability extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_traceability';
    // 关联查询所属房间
    public function device_room()
    {
         return $this->belongsTo(DeviceRoom::class);
    }
    // 关联查询所属作物
    public function crop_class()
    {
         return $this->belongsTo(CropClass::class);
    }
}
