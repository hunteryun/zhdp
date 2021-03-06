<?php

namespace App\Http\Requests\Admin;
use App\Http\Requests\Base;

class AddAdmin extends Base
{
    public $messages = [
        'name.required' => '管理员名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在6-30之间!',
        'password.required' => '密码必填!',
        'password.between' => '密码长度需要在6-20之间!',
        'password.alpha_dash' => '密码只允许字母和数字，以及破折号和下划线!',
    ];
    /**
     * Determine if the Admin is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示管理员无权限，如果要带入控制器设置为true
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
            'name' => 'required|unique:admin|alpha_dash|between:6,30',
            'password' => 'required|between:6,20|alpha_dash',   
        ];
    }
}
