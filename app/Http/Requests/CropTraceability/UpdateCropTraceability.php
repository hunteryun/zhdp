<?php

namespace App\Http\Requests\CropTraceability;
use App\Http\Requests\Base;
// 作物追溯
class UpdateCropTraceability extends Base
{
    public $messages = [
        'crop_variety.required' => '作物品种必填!',
        'crop_variety.between' => '作物品种最多255字符!',
        'number_of_plants.required' => '种植数量必填!',
        'number_of_plants.required' => '种植数量最多255字符!',
        'start_time.required' => '种植时间必填!',
        'start_time.date' => '种植时间格式不正确!',
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //false 表示作物追溯无权限，如果要带入控制器设置为true
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
            'crop_variety' => [
                'required',
                'between:1,255'
            ],
            'number_of_plants' => [
                'required',
                'between:1,255'
            ],
            'start_time' => [
                'required',
                'date'
            ],
        ];
    }
}
