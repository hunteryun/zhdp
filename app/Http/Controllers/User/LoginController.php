<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    // 用户登录
    public function index()
    {
        return view('user/login/index');
    }

}
