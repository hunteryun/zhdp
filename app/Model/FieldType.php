<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'field_type';
    // 新增字段类型
    public function addFieldType($fieldTypeInfo = []){
        $this->name     = $fieldTypeInfo['name'];
        $this->length   = $fieldTypeInfo['length'];
        if(array_key_exists('default', $fieldTypeInfo)){
            $this->default  = $fieldTypeInfo['default'];
        }
        if(array_key_exists('desc', $fieldTypeInfo)){
            $this->desc     = $fieldTypeInfo['desc'];
        }
        return $this->save();
    }
    // 更新字段类型
    public function updateFieldType($fieldTypeInfo = [], $updateFieldType = []){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $fieldTypeInfo->name        = $updateFieldType['name'];
        $fieldTypeInfo->length    = $updateFieldType['length'];
        if(array_key_exists('default', $updateFieldType)){
            $fieldTypeInfo->default  = $updateFieldType['default'];
        }
        if(array_key_exists('desc', $updateFieldType)){
            $fieldTypeInfo->desc     = $updateFieldType['desc'];
        }
        return $fieldTypeInfo->save();
    }
    // 删除字段类型
    public function deleteFieldType($fieldTypeInfo = []){
        return $fieldTypeInfo->delete();
    }
}
