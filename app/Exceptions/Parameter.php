<?php

namespace App\Exceptions;
// 参数验证错误
class Parameter extends Base
{
    // http错误码 200 ：错误请求，如语法错误
    public $httpCode = 200;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $message = '参数验证失败';
}