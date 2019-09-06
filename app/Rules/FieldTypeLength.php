<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Model\FieldType as FieldTypeModel;
class FieldTypeLength implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute 字段名
     * @param  mixed  $value 字段值
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 判断是否符合指定类型长度
        $field_type_id = request()->input('field_type_id');
        $field_type_length = FieldTypeModel::where('id', $field_type_id)->firstOrFail(['field_type_length'])->field_type_length;
        if(intval($value) >  $field_type_length){
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '字段类型长度不符合要求';
    }
}
