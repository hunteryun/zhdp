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
    // 更新用户
    public function updateUser($userInfo = [], $updateUserInfo = []){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $userInfo->name     = $updateUserInfo['name'];
        $userInfo->password = $updateUserInfo['password'];
        return $userInfo->save();
    }
    // 删除用户
    public function deleteUser($userInfo = []){
        return $userInfo->delete();
    }

}
