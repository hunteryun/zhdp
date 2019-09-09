<?php

namespace App\Http\Requests\CropClass;
use App\Http\Requests\Base;
use App\Rules\CropClassPidExists; // 引入判断是不是真实的作物id
// 作物分类
class AddCropClass extends Base
{
    public $messages = [
        'name.required' => '作物分类名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        
        'pid.required' => '区域id必填!',
        'pid.numeric' => '区域id必须是数字!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示作物分类无权限，如果要带入控制器设置为true
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
                'unique:crop_class',
                'alpha_dash',
                'between:1,60',
            ],
            'pid' => [
                'required',
                'numeric',
                new CropClassPidExists,
            ]
        ];
    }
}
