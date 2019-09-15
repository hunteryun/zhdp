<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 登陆通知
class LoginNotice extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'login_notice';
}
