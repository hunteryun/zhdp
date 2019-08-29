<?php

namespace App\Exceptions;
// 404页面错误
class NotFoundUrl extends Base
{
    // http错误码 404 ：错误请求，如语法错误
    public $httpCode = 404;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $message = '未找到页面';
}