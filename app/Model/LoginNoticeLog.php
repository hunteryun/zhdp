<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 登陆通知记录
class LoginNoticeLog extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'login_notice_log';
    // 关联查询所属日志
    public function login_notice()
    {
         return $this->belongsTo(LoginNotice::class);
    }
}
