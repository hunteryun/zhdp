<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;

class User extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'user';
    // 指定可以批量赋值的字段
    // protected $fillable = ['token', 'name', 'class', 'phone'];
    // 获取分页
    public function getPaginate($request){
        return $this->paginate($request->input('limit'))->toArray();
    }
    // 获取所有
    public function getAll($request){
        return $this->all();
    }
    // 获取单个
    public function getFind($id){
        try{
            return $this->findOrFail($id);
        }catch(\Exception $exception){
            throw new IdNotFound('用户Id未找到');
        }
    }
    // 新增用户
    public function addUser($request){
        $this->name      = $request->input('name');
        $this->password    = $request->input('password');
        return $this->save();
    }
    // 更新用户
    public function updateUser($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $userInfo            = $this->getFind($id);
        $userInfo->name      = $request->input('name');
        $userInfo->password    = $request->input('password');
        return $userInfo->save();
    }
    // 删除用户
    public function deleteUser($id){
        $userInfo = $this->getFind($id);
        return $userInfo->delete();
    }

}
