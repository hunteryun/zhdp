<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 作物收获批次
class CropTraceabilityBatch extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_traceability_batch';
    // 关联查询所属追溯
    public function crop_traceability()
    {
         return $this->belongsTo(CropTraceability::class);
    }
}
