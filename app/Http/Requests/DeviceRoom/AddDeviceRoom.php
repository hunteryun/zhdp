<?php

namespace App\Http\Requests\DeviceRoom;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\UserIdExists; // 引入判断是不是真实的用户id 
use App\Rules\DeviceRegionIdExists; // 引入判断是不是真实的区域
// 设备房间
class AddDeviceRoom extends Base
{
    public $messages = [
        'name.required' => '设备房间名必填!',
        'name.unique' => '区域下已存在相同房间名!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'user_id.required' => '用户id必填!',
        'user_id.numeric' => '用户id必须是数字!',
        'device_region_id.required' => '区域id必填!',
        'device_region_id.numeric' => '区域id必须是数字!',
        'desc.max' => '描述最多120字符!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示设备房间无权限，如果要带入控制器设置为true
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
                // 验证区域下房间名是否唯一
                Rule::unique('device_room')->where('device_region_id', $this->request->device_region_id),
                'alpha_dash',
                'between:1,30',
            ],
            'user_id' => [
                'required',
                'numeric',
                new UserIdExists
            ], 
            'device_region_id' => [
                'required',
                'numeric',
                new DeviceRegionIdExists
            ],   
            'desc'  => 'max:120',
        ];
    }
}
