<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\Admin as AdminModel;
use App\Http\Requests\Admin\LoginAdmin as LoginAdminRequests;
use App\Exceptions\ModelNotFound;
class LoginController extends Base
{
    // 管理登录
    public function index(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new LoginAdminRequests)->verification($request);
        try{
            $userInfo = (new AdminModel)->where([
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
    // 管理退出出
    public function out(Request $request){
        $adminModel = AdminModel::where('token', $this->admin_token())->firstOrFail();
        $adminModel->token = "";
        $adminModel->save();
        return success(['msg'=>"退出成功"]);
    }
}
