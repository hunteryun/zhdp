<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\Admin as AdminModel;
use App\Http\Requests\Admin\AddAdmin as AddAdminRequests;
class RegController extends Base
{
    // 管理员注册
    public function index(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new AddAdminRequests)->verification($request);
        $adminModel = new AdminModel;
        $userToken = str_random(60);
        $adminModel->name        = $request->input('name');
        // $adminModel->phone       = $request->input('phone');
        $adminModel->password    = $request->input('password');
        $adminModel->token       = $userToken;
        $addUserStatus = $adminModel->save();
        if(!$addUserStatus){
            return errors(['msg'=>"管理员创建失败"]);
        }
        return success(['msg'=>"管理员创建成功",'token' => $userToken]);
    }
}
