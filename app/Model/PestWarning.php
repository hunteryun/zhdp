<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 病虫害预警
class PestWarning extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'pest_warning';
}
