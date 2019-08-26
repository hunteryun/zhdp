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
    // 新增用户
    public function addUser($userInfo = []){
        $this->name = $userInfo['name'];
        $this->password = $userInfo['password'];
        return $this->save();
    }

}
