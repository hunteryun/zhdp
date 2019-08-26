<?php

namespace App\Exceptions;
// 参数验证错误
class Parameter extends Base
{
    // http错误码 400 ：错误请求，如语法错误
    public $httpCode = 400;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
}