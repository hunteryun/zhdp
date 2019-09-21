<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 作物收获批次
class CropTraceabilityBatch extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_traceability_batch';
}
