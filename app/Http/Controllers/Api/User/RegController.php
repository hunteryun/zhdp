<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Http\Requests\User\AddUser as AddUserRequests;
use App\Http\Requests\User\UpdateUser as UpdateUserRequests;
class RegController extends Controller
{
    // 用户注册
    public function index(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new AddUserRequests)->verification($request);
        $userModel = new UserModel;
        $userToken = getOnlyToken_60();
        $userModel->name        = $request->input('name');
        // $userModel->phone       = $request->input('phone');
        $userModel->password    = $request->input('password');
        $userModel->token       = $userToken;
        $addUserStatus = $userModel->save();
        if(!$addUserStatus){
            return errors(['msg'=>"用户创建失败"]);
        }
        return success(['msg'=>"用户创建成功",'token' => $userToken]);
    }
}
