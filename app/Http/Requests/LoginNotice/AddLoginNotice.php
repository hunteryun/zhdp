<?php

namespace App\Http\Requests\LoginNotice;
use App\Http\Requests\Base;
// 登陆通知
class AddLoginNotice extends Base
{
    public $messages = [
        'title.required' => '登陆通知名必填!',
        'title.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'title.between' => '名字长度需要在1-255之间!',
        'content.required' => '内容必填!',
        'content.between' => '内容需要在1-65535之间!',
        'type.required' => '类型必填!',
        'type.numeric' => '类型必须是数字!',
        'type.in' => '类型必须是0或1!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示登陆通知无权限，如果要带入控制器设置为true
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
            'title' => 'required|alpha_dash|between:1,255',
            'content' => 'required|between:1,255',
            'type' => 'required|numeric|in:0,1',
        ];
    }
}
