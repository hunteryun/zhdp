<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 产品字段
class ProductField extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'product_field';
    // 设置默认值 length 字段
    public function setLengthAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['length'] = 0;
        }else{
            $this->attributes['length'] = $value;
        }
    }
    // 设置默认值 default 字段
    public function setDefaultAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['default'] = '';
        }else{
            $this->attributes['default'] = $value;
        }
    }
    // 设置默认值 common_field 字段
    public function setCommonFieldAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['common_field'] = '';
        }else{
            $this->attributes['common_field'] = $value;
        }
    }
    // 设置默认值 common_field_sort 字段
    public function setCommonFieldSortAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['common_field_sort'] = 0;
        }else{
            $this->attributes['common_field_sort'] = $value;
        }
    }
    // 设置默认值 desc 字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
    // 设置默认值 sort 字段
    public function setSortAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['sort'] = 0;
        }else{
            $this->attributes['sort'] = $value;
        }
    }
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
            throw new IdNotFound('产品字段Id未找到');
        }
    }
    // 新增产品字段
    public function addProductField($request){
        $this->product_id    = $request->input('product_id');
        $this->name          = $request->input('name');
        $this->field         = $request->input('field');
        $this->field_type_id = $request->input('field_type_id');
        $this->length        = $request->input('length');
        $this->default       = $request->input('default');
        $this->common_field  = $request->input('common_field');
        $this->common_field_sort  = $request->input('common_field_sort');
        $this->desc          = $request->input('desc');
        $this->sort          = $request->input('sort');
        return $this->save();
    }
    // 更新产品字段
    public function updateProductField($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $productFieldInfo                = $this->getFind($id);
        $productFieldInfo->product_id    = $request->input('product_id');
        $productFieldInfo->name          = $request->input('name');
        $productFieldInfo->field         = $request->input('field');
        $productFieldInfo->field_type_id = $request->input('field_type_id');
        $productFieldInfo->length        = $request->input('length');
        $productFieldInfo->default       = $request->input('default');
        $productFieldInfo->common_field  = $request->input('common_field');
        $productFieldInfo->common_field_sort  = $request->input('common_field_sort');
        $productFieldInfo->desc          = $request->input('desc');
        $productFieldInfo->sort          = $request->input('sort');
        return $productFieldInfo->save();
    }
    // 删除产品字段
    public function deleteProductField($id){
        $productFieldInfo = $this->getFind($id);
        return $productFieldInfo->delete();
    }
}
