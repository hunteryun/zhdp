<?php

namespace App\Http\Requests\Product;
use App\Http\Requests\Base;
// 产品
class AddProduct extends Base
{
    public $messages = [
        'name.required' => '产品名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'desc.max' => '描述最多120字符!',
        
    ];
    /**
     * Determine if the Product is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示产品无权限，如果要带入控制器设置为true
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
            'name' => 'required|unique:product|alpha_dash|between:1,30',
            'desc' => 'max:120',   
        ];
    }
}
