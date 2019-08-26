<?php

namespace App\Http\Requests;

class AddUser extends Base
{
    public $messages = [
        'name.required' => '用户名必填!',
        'password.required' => '密码必填!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required',
            'password' => 'required',
        ];
    }
}
