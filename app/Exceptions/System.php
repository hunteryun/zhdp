<?php

namespace App\Exceptions;

class System extends Base
{
    // http错误码
    public $httpCode = 500;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
    //
    public $msg = '服务器内部错误';
}