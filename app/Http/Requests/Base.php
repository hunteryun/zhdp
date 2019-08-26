<?php

namespace App\Http\Requests;
use Validator;
use App\Exceptions\Parameter;
use Illuminate\Foundation\Http\FormRequest;

class Base extends FormRequest
{
    /**
     * 验证
     */
    public function verification($request){
        $validator = Validator::make($request->all(), $this->rules(), $this->messages);
        if($validator->fails()){
            $error = $validator->errors()->first();
            throw (new Parameter())->render($error);
        }
    }
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
            //
        ];
    }
}
