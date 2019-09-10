<?php

namespace App\Http\Requests\ArticleComment;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
use App\Rules\DeviceRegionIdExists; // 引入判断是不是真实的区域
use App\Rules\CropClassIdExists; // 引入判断是不是真实的作物
// 文章评论
class UpdateArticleComment extends Base
{
    public $messages = [
        'article_id.required' => '文章id必填!',
        'article_id.numeric' => '文章id必须是数字!',
        'content.required' => '文章评论必填!',
        'content.between' => '文章评论长度需要在1-65535之间!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示文章评论无权限，如果要带入控制器设置为true
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
            'content' => [
                'required',
                'between:1,65535',
            ],   
        ];
    }
}
