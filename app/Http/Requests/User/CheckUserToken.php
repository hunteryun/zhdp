<?php

namespace App\Http\Requests\User;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
// 验证用户token
class CheckUserToken extends Base
{
    public $messages = [
        'name.required' => 'Token必填!',
        'name.string' => 'Token只允字符串!',
        'name.size' => 'Token不符合要求!',
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
            'name' => [
                'required',
                'string',
                'size:60',
            ],
        ];
    }
}
