<?php

namespace App\Http\Requests\User;
use App\Http\Requests\Base;

class AddUser extends Base
{
    public $messages = [
        'name.required' => '用户名必填!',
        'name.unique' => '名字已经存在!',
        'name.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'name.between' => '名字长度需要在6-30之间!',

        'phone.required' => '手机号必填!',
        'phone.digits' => '手机号必须为11位数字!',
        'phone.unique' => '手机号已存在!',

        'password.required' => '密码必填!',
        'password.between' => '密码长度需要在6-20之间!',
        'password.alpha_dash' => '密码只允许字母和数字，以及破折号和下划线!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示用户无权限，如果要带入控制器设置为true
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
            'name' => 'required|unique:user|alpha_dash|between:6,30',
            'password' => 'required|between:6,20|alpha_dash',   
            'phone' => 'required|digits:11|unique:user'
        ];
    }
}
