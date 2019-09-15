<?php

namespace App\Http\Requests\SystemSettingsGroupField;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\SystemSettingsGroupIdExists; // 引入判断设置组id是否存在
// 系统设置字段
class UpdateSystemSettingsGroupField extends Base
{
    public $messages = [
        'system_settings_group_id.required' => '系统设置组id必填!',
        'system_settings_group_id.numeric' => '系统设置组id必须是数字!',
        'name.required' => '系统设置字段名必填!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'field.required' => '唯一标识符必填!',
        'field.between' => '唯一标识符长度需要在1-255之间!',
        'field.unique' => '唯一标识符重复!',
        'desc.max' => '描述最多120字符!',
        'value.required' => '值必填!',
        'value.max' => '值最多65535个字符!',
        'type.numeric' => '类型必须是数字!',
        'type.required' => '类型必填!',
        'type.in' => '类型必须时0,1,2,3!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示系统设置字段无权限，如果要带入控制器设置为true
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
            'system_settings_group_id'=>[
                new SystemSettingsGroupIdExists,
                'required',
                'numeric',
            ],
            'name' => [
                'required',
                'alpha_dash',
                'between:1,30',
            ],
            'field' => [
                'required',
                Rule::unique('system_settings_group_field')->ignore($this->request->id),
                'between:1,255',
            ], 
            'desc'  => 'max:120',
            'value' => [
                'required',
                'max:65535',
            ],  
            'type' => [
                'required',
                'numeric',
                'in:0,1,2,3',
            ],   
        ];
    }
}
