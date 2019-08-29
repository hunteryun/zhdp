<?php

namespace App\Http\Requests\DeviceField;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\DeviceIdExists; // 引入判断设备id是否存在
use App\Rules\FieldTypeIdExists; // 引入判断字段类型id是否存在
// 设备字段
class AddDeviceField extends Base
{
    public $messages = [
        'device_id.required' => '设备id必填!',
        'device_id.numeric' => '设备id必须是数字!',
        'name.required' => '设备字段名必填!',
        'name.unique' => '设备下已存在相同名字!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'field.required' => '设备字段标识符必填!',
        'field.unique' => '设备下已存在相同字段标识符!',
        'field.alpha_dash' => '设备字段标识符只允许字母和数字，以及破折号和下划线!',
        'field.between' => '设备字段标识符长度需要在1-30之间!',
        'field_type_id.required' => '字段类型id必填!',
        'field_type_id.numeric' => '字段类型id必须是数字!',
        'value.alpha_dash' => '设备字字段值只允许字母和数字，以及破折号和下划线!',
        'value.max' => '设备字段值最多255个字符!',
        'length.numeric' => '字段长度id必须是数字!',
        'length.between' => '字段长度要在1-255之间!',
        'common_field.alpha_dash'  => '设备字默认值只允许字母和数字，以及破折号和下划线!',
        'common_field.max'  => '设备字段最多30个字符!',
        'common_field_sort.numeric' => '共同字段排序参数必须是数字!',
        'common_field_sort.max' => '共同字段排序参数最大65535!',
        'sort.numeric' => '设备字段排序参数必须是数字!',
        'sort.max' => '设备字段排序参数最大65535!',
        'desc.max' => '描述最多120字符!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示设备字段无权限，如果要带入控制器设置为true
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
            'device_id' => [
                'required',
                'numeric',
                new DeviceIdExists,
            ],
            'name' => [
                'required',
                Rule::unique('device_field')->where('device_id', $this->request->device_id),
                'alpha_dash',
                'between:1,30',
            ],
            'field' => [
                'required',
                Rule::unique('device_field')->where('device_id', $this->request->device_id), 
                'alpha_dash',
                'between:1,30',
            ],
            'field_type_id' => [
                'required',
                'numeric',
                new FieldTypeIdExists,
            ],
            'value' => [
                'alpha_dash',
                'max:255',
            ],
            'length' => [
                'numeric',
                'between:1,255',
            ],
            'common_field' => [
                'alpha_dash',
                'max:30'
            ],
            'common_field_sort' => [
                'numeric',
                'max:65535'
            ],
            'sort' => [
                'numeric',
                'max:65535'
            ],
            'desc' => [
                'max:120'
            ],
        ];
    }
}
