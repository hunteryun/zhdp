<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'user';
    // 指定可以批量赋值的字段
    // protected $fillable = ['token', 'name', 'class', 'phone'];
}
