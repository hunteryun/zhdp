<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 系统设置组
class SystemSettingsGroup extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'system_settings_group';
}
