<?php

namespace App\Http\Requests\CropTraceability;
use App\Http\Requests\Base;
use App\Rules\UserDeviceRoomIdExists; // 引入判断设备房间id是否存在
use App\Rules\UserDeviceRoomCropTracebackDidNotProceed; // 房间id下，不能存在正在进行的追溯，如果存在则不能增加
// 作物追溯
class AddCropTraceability extends Base
{
    public $messages = [
        'device_room_id.required' => '房间id必填!',
        'device_room_id.numeric' => '房间id必须是数字!',
        'crop_variety.required' => '作物品种必填!',
        'crop_variety.between' => '作物品种最多255字符!',
        'number_of_plants.required' => '种植数量必填!',
        'number_of_plants.required' => '种植数量最多255字符!',
        'start_time.required' => '种植时间必填!',
        'start_time.date' => '种植时间格式不正确!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示作物追溯无权限，如果要带入控制器设置为true
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'device_room_id' => [
                'required',
                'numeric',
                new UserDeviceRoomIdExists,
                new UserDeviceRoomCropTracebackDidNotProceed,
            ],
            'crop_variety' => [
                'required',
                'between:1,255'
            ],
            'number_of_plants' => [
                'required',
                'between:1,255'
            ],
            'start_time' => [
                'required',
                'date'
            ],
        ];
    }
}
