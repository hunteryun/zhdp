<?php

namespace App\Http\Requests\Product;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
// 产品
class UpdateProduct extends Base
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
        // 看到已经通过接口继承了 request 但是获取数据获取不到，后面再进行优化把 
        return [
            'name' => [
                'required',
                // 验证唯一，除了自己
                Rule::unique('product')->ignore($this->request->id),
                'alpha_dash',
                'between:1,30',
            ],
            'desc' => 'max:120',   
        ];
    }
}
