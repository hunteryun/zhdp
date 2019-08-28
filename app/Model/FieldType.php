<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 字段类型
class FieldType extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'field_type';
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
        return $this->findOrFail($id);
    }
    // 新增字段类型
    public function addFieldType($request){
        $this->name      = $request->input('name');
        $this->length    = $request->input('length');
        $this->default   = $request->input('default', '');
        $this->desc      = $request->input('desc', '');
        return $this->save();
    }
    // 更新字段类型
    public function updateFieldType($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $fieldTypeInfo            = $this->getFind($id);
        $fieldTypeInfo->name      = $request->input('name');
        $fieldTypeInfo->length    = $request->input('length');
        $fieldTypeInfo->default   = $request->input('default', '');
        $fieldTypeInfo->desc      = $request->input('desc', '');
        return $fieldTypeInfo->save();
    }
    // 删除字段类型
    public function deleteFieldType($id){
        $fieldTypeInfo = $this->getFind($id);
        return $fieldTypeInfo->delete();
    }
}
