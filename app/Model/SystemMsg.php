<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 字段类型
class SystemMsg extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'system_msg';
}
