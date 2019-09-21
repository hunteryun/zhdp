<?php

namespace App\Http\Requests\CropTraceabilityEventLog;
use App\Http\Requests\Base;
use App\Rules\UserDeviceRoomIdExists; // 引入判断设备房间id是否存在
use App\Rules\UserDeviceRoomCropTracingExists; // 房间id下，是否存在正在进行的追溯
// 作物追溯
class AddCropTraceabilityEventLog extends Base
{
    public $messages = [
        // 追溯id根据房间id查询下唯一的追溯事件id进行获取到
        'device_room_id.required' => '房间id必填!',
        'device_room_id.numeric' => '房间id必须是数字!',

        'event_name.required' => '事件名必填!',
        'event_name.between' => '事件名最多120字符!',

        'event_content.required' => '事件内容必填!',
        'event_content.between' => '事件内容最多65535字符!',


        'event_time.required' => '事件时间必填!',
        'event_time.date' => '事件时间格式不正确!',
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
                new UserDeviceRoomCropTracingExists,
            ],
            'event_name' => [
                'required',
                'between:1,120'
            ],
            'event_content' => [
                'required',
                'between:1,65535'
            ],
            'event_time' => [
                'required',
                'date'
            ],
        ];
    }
}
