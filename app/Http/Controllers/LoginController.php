<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // 用户登录
    public function user()
    {
        return view('user/login');
    }

}
