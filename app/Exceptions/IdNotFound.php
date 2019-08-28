<?php

namespace App\Exceptions;
// 参数验证错误
class IdNotFound extends Base
{
    // http错误码 500 ：错误请求，如语法错误
    public $httpCode = 500;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $message = 'Id未找到';
}