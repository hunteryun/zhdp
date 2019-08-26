<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use function Opis\Closure\unserialize;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    // 成功返回
    public function success($arr = [], $httpCode = 200){
        // code 最前面 msg在他后面
        if(!array_key_exists('code', $arr)){
            $arr['code'] = 0;
        };
        if(!array_key_exists('msg', $arr)){
            $arr['msg'] = '请求成功';
        };
        // 此处必须要返回，不然会导致页面显示为空...
        return $this->ajaxReturn($arr, $httpCode);
    }
    // 错误返回
    public function errors($arr = [], $httpCode = 404){
        // code 最前面 msg在他后面
        if(!array_key_exists('code', $arr)){
            $arr['code'] = 1;
        };
        if(!array_key_exists('msg', $arr)){
            $arr['msg'] = '请求失败';
        };
        // 此处必须要返回，不然会导致页面显示为空...
        return $this->ajaxReturn($arr, $httpCode);
    }
    // 返回json
    public function ajaxReturn($arr = [], $httpCode){
        return response()->json($arr, $httpCode);
    }
}
