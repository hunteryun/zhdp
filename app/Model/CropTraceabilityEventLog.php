<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 作物追溯
class CropTraceabilityEventLog extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_traceability_event_log';
}
