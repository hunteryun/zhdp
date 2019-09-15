<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 病虫害预警日志
class PestWarningLog extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'pest_warning_log';
    // 关联查询所属预警
    public function pest_warning()
    {
         return $this->belongsTo(PestWarning::class);
    }
}
