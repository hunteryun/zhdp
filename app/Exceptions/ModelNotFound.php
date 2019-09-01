<?php

namespace App\Exceptions;
// 模型未找到结果
class ModelNotFound extends Base
{
    // http错误码 200 ：错误请求，如语法错误
    public $httpCode = 200;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $message = '模型查询不到';
}