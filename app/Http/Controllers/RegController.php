<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegController extends Controller
{
    // 用户注册
    public function user()
    {
        return view('user/reg');
    }

}
