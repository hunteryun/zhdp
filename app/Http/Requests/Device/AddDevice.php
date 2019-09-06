<?php

namespace App\Http\Requests\Device;
use App\Http\Requests\Base;
use App\Rules\ProductIdExists; // 引入判断产品id是否存在
use App\Rules\UserDeviceRegionIdExists; // 引入判断是不是真实的区域
use App\Rules\UserDeviceRoomIdExists; // 引入判断设备房间id是否存在
// 设备
class AddDevice extends Base
{
    public $messages = [
        'product_id.required' => '产品id必填!',
        'product_id.numeric' => '产品id必须是数字!',
        'device_region_id.required' => '区域id必填!',
        'device_region_id.numeric' => '区域id必须是数字!',
        'device_room_id.required' => '设备房间id必填!',
        'device_room_id.numeric' => '设备房间id必须是数字!',
        'name.required' => '设备名必填!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'desc.max' => '描述最多120字符!',
    ];
    /**
     * Determine if the Device is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示设备无权限，如果要带入控制器设置为true
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
            'product_id' => [
                'required',
                'numeric',
                new ProductIdExists,
            ],
            'device_region_id' => [
                'required',
                'numeric',
                new UserDeviceRegionIdExists
            ],
            'device_room_id' => [
                'required',
                'numeric',
                new UserDeviceRoomIdExists,
            ],
            'name' => 'required|alpha_dash|between:1,30',
            'desc' => 'max:120',   
        ];
    }
}
