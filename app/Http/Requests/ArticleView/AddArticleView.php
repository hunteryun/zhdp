<?php

namespace App\Http\Requests\ArticleView;
use App\Http\Requests\Base;
use App\Rules\ArticleIdExists; // 引入判断文章id是否存在
// 文章浏览记录
class AddArticleView extends Base
{
    public $messages = [
        'article_id.required' => '文章id必填!',
        'article_id.numeric' => '文章id必须是数字!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示文章浏览记录无权限，如果要带入控制器设置为true
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
            'article_id' => [
                'required',
                'numeric',
                new ArticleIdExists
            ], 
        ];
    }
}
