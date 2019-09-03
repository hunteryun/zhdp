<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
class Base extends Controller
{
    /**
     * 获取用户token
     * @return string;
     */
    public function user_token(){
        return request()->header('token');
    }
}
