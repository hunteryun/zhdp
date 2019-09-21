<?php

namespace App\Http\Requests\CropTraceabilityBatch;
use App\Http\Requests\Base;
use App\Rules\UserDeviceRoomIdExists; // 引入判断设备房间id是否存在
use App\Rules\UserDeviceRoomCropTracingExists; // 房间id下，是否存在正在进行的追溯
// 作物收获批次
class AddCropTraceabilityBatch extends Base
{
    public $messages = [
        // 追溯id根据房间id查询下唯一的追溯事件id进行获取到
        'device_room_id.required' => '房间id必填!',
        'device_room_id.numeric' => '房间id必须是数字!',
        'harvest_quantity.required' => '事件名必填!',
        'harvest_quantity.between' => '事件名最多120字符!',
        'end_time.required' => '事件时间必填!',
        'end_time.date' => '事件时间格式不正确!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示作物收获批次无权限，如果要带入控制器设置为true
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
                new UserDeviceRoomCropTracingExists,
            ],
            'harvest_quantity' => [
                'required',
                'between:1,255'
            ],
            'end_time' => [
                'required',
                'date'
            ],
        ];
    }
}
