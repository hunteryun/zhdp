<?php

namespace App\Http\Requests\Device;
use App\Http\Requests\Base;
// use Illuminate\Validation\Rule;
// 设备
class UpdateDevice extends Base
{
    public $messages = [
        // 'user_id.required' => '用户id必填!',
        // 'user_id.numeric' => '用户id必须是数字!',
        // 'product_id.required' => '产品id必填!',
        // 'product_id.numeric' => '产品id必须是数字!',
        // 'device_room_id.required' => '设备房间id必填!',
        // 'device_room_id.numeric' => '设备房间id必须是数字!',
        'name.required' => '设备名必填!',
        // 'name.unique' => '名字已经存在!', // 设备名字允许重复
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
            // 'user_id' => [
            //     'required',
            //     'numeric',
            //     new UserIdExists
            // ],   
            // 'product_id' => [
            //     'required',
            //     'numeric',
            //     new ProductIdExists,
            // ],
            // 'device_room_id' => [
            //     'required',
            //     'numeric',
            //     new DeviceRoomIdExists,
            // ],
            'name' => [
                'required',
                // 验证唯一，除了自己
                // Rule::unique('device')->ignore($this->request->id),
                'alpha_dash',
                'between:1,30',
            ],
            'desc' => 'max:120',   
        ];
    }
}
