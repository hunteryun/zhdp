<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
class Base extends Controller
{
    /**
     * 获取管理员token
     * @return string;
     */
    public function admin_token(){
        return request()->header('authorization');
    }
}
