<?php

namespace App\Http\Requests\PestWarning;
use App\Http\Requests\Base;
use Illuminate\Validation\Rule;
// 病虫害预警
class UpdatePestWarning extends Base
{
    public $messages = [
        'title.required' => '病虫害预警名必填!',
        'title.alpha_dash' => '名字只允许字母和数字，以及破折号和下划线!',
        'title.between' => '名字长度需要在1-30之间!',

        'type.required' => '字段长度必填!',
        'type.in' => '类型必须是0或1!',

        'start_time.date' => '开始时间必须是时间格式!',
        'end_time.date' => '结束时间必须是时间格式!',

        'warning.required' => '预警信息必填!',
        'warning.max' => '预警信息最多65535个字符!',

        'content.required' => '防治措施必填!',
        'content.max' => '防治措施最多65535个字符!',

    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示病虫害预警无权限，如果要带入控制器设置为true
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
            'type' => 'required|in:0,1',   
            'start_time' => 'date|nullable',   
            'end_time' => 'date|nullable',    
            'warning' => 'required|max:65535',   
            'content' => 'required|max:65535',   
        ];
    }
}
