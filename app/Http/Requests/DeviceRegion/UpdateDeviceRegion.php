<?php

namespace App\Http\Requests\DeviceRegion;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\UserIdExists; // 引入判断是不是真实的用户id 
// 设备区域
class UpdateDeviceRegion extends Base
{
    public $messages = [
        'name.required' => '设备区域名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'user_id.required' => '用户id必填!',
        'user_id.numeric' => '用户id必须是数字!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示设备区域无权限，如果要带入控制器设置为true
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
                // 验证唯一，除了自己
                Rule::unique('device_region')->where('user_id', $this->request->user_id)->ignore($this->request->id),
                'alpha_dash',
                'between:1,30',
            ],
            'user_id' => [
                'required',
                'numeric',
                'between:1,255',
                new UserIdExists
            ],   
        ];
    }
}
