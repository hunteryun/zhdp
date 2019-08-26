<?php

namespace App\Exceptions;

use App\Exceptions\Base;

class AddUser extends Base
{
    // http错误码
    public $httpCode = 500;
    // 状态 0 正常 1 错误
    public $statusCode = 1;
}