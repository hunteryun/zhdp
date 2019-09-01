<?php

namespace App\Exceptions;
// 用户Token过去
class UserTokenExpired extends Base
{
    // http错误码 200 ：错误请求，如语法错误
    public $httpCode = 200;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $message = '用户Token已过期';
}