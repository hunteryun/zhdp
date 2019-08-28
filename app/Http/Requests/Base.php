<?php

namespace App\Http\Requests;
use Validator;
use App\Exceptions\Parameter;
use Illuminate\Foundation\Http\FormRequest;

class Base extends FormRequest
{
    public function __construct(){
        $this->request = request();
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
    /**
     * 验证[get参数获取不到 需要 key->value 传入]
     */
    public function verification($request = ""){
        $validator = Validator::make($this->request->all(), $this->rules(), $this->messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            // 抛出参数验证错误类
            throw (new Parameter($error));
        }
    }
}
