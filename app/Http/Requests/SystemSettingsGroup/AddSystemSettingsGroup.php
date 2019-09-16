<?php

namespace App\Http\Requests\SystemSettingsGroup;
use App\Http\Requests\Base;
// 系统设置组
class AddSystemSettingsGroup extends Base
{
    public $messages = [
        'field.required' => '设置组字段标识符必填!',
        'field.unique' => '设置组下已存在相同字段标识符!',
        'field.alpha_dash' => '设置组字段标识符只允许字母和数字，以及破折号和下划线!',
        'field.between' => '设置组字段标识符长度需要在1-30之间!',

        'name.required' => '系统设置组名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'desc.max' => '描述最多255个字符!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示系统设置组无权限，如果要带入控制器设置为true
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
            'field' => [
                'required',
                'unique:system_settings_group',
                'alpha_dash',
                'between:1,30',
            ],
            'name' => 'required|unique:system_settings_group|alpha_dash|between:1,30',
            'desc' => 'max:255',   
        ];
    }
}
