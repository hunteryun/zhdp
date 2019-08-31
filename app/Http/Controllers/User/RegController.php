<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegController extends Controller
{
    // 用户注册
    public function index()
    {
        return view('user/reg/index');
    }

}
