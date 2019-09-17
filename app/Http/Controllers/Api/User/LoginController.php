<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Http\Requests\User\LoginUser as LoginUserRequests;
use App\Exceptions\ModelNotFound;
class LoginController extends Base
{
    // 用户登录
    public function index(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new LoginUserRequests)->verification($request);
        try{
            $userInfo = (new UserModel)->where([
                ['name', '=', $request->input('name')],
                ['password', '=', $request->input('password')],
            ])->firstOrFail();
        }catch(\Exception $exception){
            throw new ModelNotFound('用户密码或账号错误');
        }
        $userToken = str_random(60);
        $userInfo->token = $userToken;
        $addUserStatus = $userInfo->save();
        if(!$addUserStatus){
            return errors(['msg'=>"登录失败"]);
        }
        return success(['msg'=>"登录成功",'token' => $userToken]);
    }
    // 用户退出
    public function out(Request $request){
        $userModel = UserModel::where('token', $this->admin_token())->firstOrFail();
        $userModel->token = "";
        $userModel->save();
        return success(['msg'=>"退出成功"]);
    }
}
