<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Model\User as UserModel;
class UserDeviceRoomIdExists implements Rule
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
        // 查询指定区域id是否存在
        return UserModel::where('token', request()->header('authorization'))->firstOrFail()->device_room()->where('id', '=', $value)->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '设备房间id不存在';
    }
}
