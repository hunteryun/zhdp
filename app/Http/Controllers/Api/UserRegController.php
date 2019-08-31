<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class UserRegController extends Controller
{
    // 用户注册
    public function index(Request $request)
    {
        $phone      = $request->input('phone');
        $password   = $request->input('password');
        return success(['data'=>[
            'phone' => $phone,
            'password' => $password,
        ]]);
    }
}
