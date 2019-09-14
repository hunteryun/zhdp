<?php

namespace App\Http\Requests\DeviceEventLog;
use App\Http\Requests\Base;
use App\Rules\DeviceIdExists; // 引入判断设备id是否存在
use App\Rules\DeviceFieldIdExists; // 引入判断设备字段id是否存在
// 设备事件日志
class AddDeviceEventLog extends Base
{
    public $messages = [
        'name.required' => '设备事件日志名必填!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'type.required' => '设备事件日志类型名必填!',
        'type.numeric' => '设备事件日志类型必须是数字!',
        'type.in' => '设备事件日志类型必须in 0,1,2!',
        'value.required' => '设备事件日志值必填!',
        'value.alpha_dash' => '值只允许字母和数字，以及破折号和下划线!',
        'value.between' => '设备事件日志值长度需要在1-255之间!',
        // 'desc.required' => '设备事件日志描述必填!',
        // 'desc.alpha_dash' => '描述只允许字母和数字，以及破折号和下划线!',
        'desc.max' => '设备事件日志描述最大长度255!',
        'device_region_id.required' => '设备日志区域id必填!',
        'device_region_id.numeric' => '设备日志区域id必须是数字!',
        'device_room_id.required' => '设备日志房间id必填!',
        'device_room_id.numeric' => '设备日志房间id必须是数字!',
        'device_id.required' => '设备id必填!',
        'device_id.numeric' => '设备id必须是数字!',
        'device_field_id.required' => '设备字段id必填!',
        'device_field_id.numeric' => '设备字段id必须是数字!',
        'associated_device_id.required' => '响应设备id必填!',
        'associated_device_id.numeric' => '响应设备id必须是数字!',
        'associated_device_field_id.required' => '响应设备字段id必填!',
        'associated_device_field_id.numeric' => '响应设备字段id必须是数字!',
        'operation_type.required' => '操作类型名必填!',
        'operation_type.numeric' => '操作类型必须是数字!',
        'operation_type.in' => '操作类型必须in 0,1!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示设备事件日志无权限，如果要带入控制器设置为true
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
            'name' => [
                'required',
                'alpha_dash',
                'between:1,30',
            ],
            'type' => [
                'required',
                'numeric',
                'in:0,1,2',
            ],
            'value' => [
                'required',
                'alpha_dash',
                'between:1,255',
            ],
            'desc' => [
                'alpha_dash',
                'max:255',
            ],
            'device_region_id' => [
                'required',
                'numeric',
                new DeviceRegionIdExists,
            ],
            'device_room_id' => [
                'required',
                'numeric',
                new DeviceRoomIdExists,
            ],
            'device_id' => [
                'required',
                'numeric',
                new DeviceIdExists,
            ],
            'device_field_id' => [
                'required',
                'numeric',
                new DeviceFieldIdExists,
            ],
            'associated_device_id' => [
                'required',
                'numeric',
                new DeviceIdExists,
            ],
            'associated_device_field_id' => [
                'required',
                'numeric',
                new DeviceFieldIdExists,
            ],
            'operation_type' => [
                'required',
                'numeric',
                'in:0,1',
            ],
        ];
    }
}
