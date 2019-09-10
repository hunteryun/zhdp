<?php

namespace App\Http\Requests\ArticleClass;
use App\Http\Requests\Base;
// 文章分类
class AddArticleClass extends Base
{
    public $messages = [
        'name.required' => '文章分类名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在1-60之间!',
        'desc.max' => '描述最多255个字符!',
        'sort.numeric' => '排序必须是数字!',
        'sort.max' => '排序最大65535!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示文章分类无权限，如果要带入控制器设置为true
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
            'name' => 'required|unique:article_class|alpha_dash|between:1,60',
            'desc' => 'max:255',   
            'sort' => 'numeric|max:65535',
        ];
    }
}
