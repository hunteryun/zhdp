<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Model\CropClass as CropClassModel;
class CropClassPidExists implements Rule
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
        // 查询指定用户id是否存在
        return CropClassModel::where('id', '=', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '用户id不存在';
    }
}
