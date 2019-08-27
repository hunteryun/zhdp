<?php

namespace App\Http\Requests\FieldType;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;

class UpdateFieldType extends Base
{
    public $messages = [
        'name.required' => '字段类型名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'length.required' => '字段长度必填!',
        'length.numeric' => '字段长度必须是数字!',
        'length.between' => '字段长度需要在1-255之间!',
        'default.max' => '默认值最多255个字符!',
        'desc.max' => '描述最多255个字符!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示字段类型无权限，如果要带入控制器设置为true
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($request)
    {
        // 看到已经通过接口继承了 request 但是获取数据获取不到，后面再进行优化把 
        return [
            'name' => [
                'required',
                // 验证唯一，除了自己
                Rule::unique('field_type')->ignore($request->id),
                'alpha_dash',
                'between:1,30',
            ],
            'length' => 'required|numeric|between:1,255',   
            'default' => 'max:255',   
            'desc' => 'max:255',   
        ];
    }
}
