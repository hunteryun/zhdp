<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 系统设置字段
class SystemSettingsGroupField extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'system_settings_group_field';
    // 关联查询所属设置组
    public function system_settings_group()
    {
         return $this->belongsTo(SystemSettingsGroup::class);
    }
}
