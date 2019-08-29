<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 产品
class Product extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'product';
    // 关联关系
    // 关联产品下的字段
    public function product_field()
    {
         return $this->hasMany(ProductField::class);
    }
    // 自动填充
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(empty($value)){
            $this->attributes['desc'] = '';
        }
    }
    // 获取分页
    public function getPaginate($request){
        return $this->with('product_field')->paginate($request->input('limit'))->toArray();
    }
    // 获取所有
    public function getAll($request){
        return $this->all();
    }
    // 获取单个
    public function getFind($id){
        try{
            return $this->with('product_field')->findOrFail($id);
        }catch(\Exception $exception){
            throw new IdNotFound('产品Id未找到');
        }
    }
    // 新增产品
    public function addProduct($request){
        $this->name     = $request->input('name');
        $this->desc     = $request->input('desc');
        return $this->save();
    }
    // 更新产品
    public function updateProduct($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $productInfo            = $this->getFind($id);
        $productInfo->name      = $request->input('name');
        $productInfo->desc      = $request->input('desc');
        return $productInfo->save();
    }
    // 删除产品
    public function deleteProduct($id){
        $productInfo = $this->getFind($id);
        return $productInfo->delete();
    }

}
