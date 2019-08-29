<?php

namespace App\Http\Requests\ProductField;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\ProductIdExists; // 引入判断产品id是否存在
use App\Rules\FieldTypeIdExists; // 引入判断字段类型id是否存在
// 产品字段
class UpdateProductField extends Base
{
    public $messages = [
        'product_id.required' => '产品id必填!',
        'product_id.numeric' => '产品id必须是数字!',
        'name.required' => '产品字段名必填!',
        'name.unique' => '产品下已存在相同名字!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-30之间!',
        'field.required' => '产品字段标识符必填!',
        'field.unique' => '产品下已存在相同字段标识符!',
        'field.alpha_dash' => '产品字段标识符只允许字母和数字，以及破折号和下划线!',
        'field.between' => '产品字段标识符长度需要在1-30之间!',
        'field_type_id.required' => '字段类型id必填!',
        'field_type_id.numeric' => '字段类型id必须是数字!',
        'length.numeric' => '字段长度id必须是数字!',
        'length.between' => '字段长度要在1-255之间!',
        'default.alpha_dash' => '产品字默认值只允许字母和数字，以及破折号和下划线!',
        'default.max' => '产品字段标默认值最多255个字符!',
        'common_field.alpha_dash'  => '产品字默认值只允许字母和数字，以及破折号和下划线!',
        'common_field.max'  => '产品字段最多30个字符!',
        'common_field_sort.numeric' => '共同字段排序参数必须是数字!',
        'common_field_sort.max' => '共同字段排序参数最大65535!',
        'sort.numeric' => '产品字段排序参数必须是数字!',
        'sort.max' => '产品字段排序参数最大65535!',
        'desc.max' => '描述最多120字符!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示产品字段无权限，如果要带入控制器设置为true
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
            'product_id' => [
                'required',
                'numeric',
                new ProductIdExists,
            ],
            'name' => [
                'required',
                Rule::unique('product_field')->where('product_id', $this->request->product_id)->ignore($this->request->id), // 相同产品下不允许存在重复名字
                'alpha_dash',
                'between:1,30',
            ],
            'field' => [
                'required',
                Rule::unique('product_field')->where('product_id', $this->request->product_id)->ignore($this->request->id), // 相同产品下不允许存在重复字段标识符
                'alpha_dash',
                'between:1,30',
            ],
            'field_type_id' => [
                'required',
                'numeric',
                new FieldTypeIdExists,
            ],
            'length' => [
                'numeric',
                'between:1,255',
            ],
            'default' => [
                'alpha_dash',
                'max:255',
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
