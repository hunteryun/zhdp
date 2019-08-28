<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;

class Product extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'product';
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
            throw new IdNotFound('产品Id未找到');
        }
    }
    // 新增产品
    public function addProduct($request){
        $this->name      = $request->input('name');
        $this->password    = $request->input('password');
        return $this->save();
    }
    // 更新产品
    public function updateProduct($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $productInfo            = $this->getFind($id);
        $productInfo->name      = $request->input('name');
        $productInfo->password    = $request->input('password');
        return $productInfo->save();
    }
    // 删除产品
    public function deleteProduct($id){
        $productInfo = $this->getFind($id);
        return $productInfo->delete();
    }

}
