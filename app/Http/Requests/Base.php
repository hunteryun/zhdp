<?php

namespace App\Http\Requests;
use Validator;
use App\Exceptions\Parameter;
use Illuminate\Foundation\Http\FormRequest;

class Base extends FormRequest
{
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
    public function rules($request)
    {
        return [
            //
        ];
    }
    /**
     * 验证
     */
    public function verification($request){
        $validator = Validator::make($request->all(), $this->rules($request), $this->messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            // 抛出参数验证错误类
            throw (new Parameter($error));
        }
    }
}
