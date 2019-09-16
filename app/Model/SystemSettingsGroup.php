<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 系统设置组
class SystemSettingsGroup extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'system_settings_group';
    // 关联组下的设置
    public function system_settings_group_field()
    {
         return $this->hasMany(SystemSettingsGroupField::class);
    }
}
