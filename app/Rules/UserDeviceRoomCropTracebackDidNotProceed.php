<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Model\CropTraceability as CropTraceabilityModel;
class UserDeviceRoomCropTracebackDidNotProceed implements Rule
{
    // 房间id下，不能存在正在进行的追溯，如果存在则不能增加
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
        // 不存在返回真，存在返回假
        return CropTraceabilityModel::where('device_room_id', $value)->where('status', '0')->exists() ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '设备房间下存在正在进行的追溯，请结束后再添加新的追溯';
    }
}
