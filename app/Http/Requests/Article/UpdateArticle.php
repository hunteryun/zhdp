<?php

namespace App\Http\Requests\Article;
use App\Http\Requests\Base;
// use Illuminate\Validation\Rule;
use App\Rules\CropClassIdExists; // 引入判断是不是真实的作物id
use App\Rules\ArticleClassIdExists; // 引入判断是不是真实的文章分类id
// 文章
class UpdateArticle extends Base
{
    public $messages = [
        'title.required' => '文章名必填!',
        'title.between' => '名字长度需要在1-120之间!',
        'content.required' => '文章内容必填!',
        'content.between' => '内容长度需要在1-65535之间!',
        'crop_class_id.required' => '作物类型id必填!',
        'crop_class_id.numeric' => '作物类型id必须是数字!',
        'article_class_id.required' => '文章分类id必填!',
        'article_class_id.numeric' => '文章分类id必须是数字!',

        // 'status.required' => '状态必填!',
        // 'status.numeric' => '状态必须是数字!',
        // 'status.in' => '状态必须是0或1!',
        // 'essence.required' => '状态必填!',
        // 'essence.numeric' => '状态必须是数字!',
        // 'essence.in' => '状态必须是0或1!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示文章无权限，如果要带入控制器设置为true
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
            'title' => [
                'required',
                'between:1,120',
            ],
            'content' => [
                'required',
                'between:1,65535',
            ],
            'crop_class_id' => [
                'required',
                'numeric',
                new CropClassIdExists,
            ],
            'article_class_id' => [
                'required',
                'numeric',
                new ArticleClassIdExists,
            ],
            // 'status' => [
            //     'required',
            //     'numeric',
            //     Rule::in(['0', '1']),
            // ],
            // 'essence' => [
            //     'required',
            //     'numeric',
            //     Rule::in(['0', '1']),
            // ],
        ];
    }
}
