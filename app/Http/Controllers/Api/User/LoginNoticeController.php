<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\LoginNotice as LoginNoticeModel;
// 登陆通知
class LoginNoticeController extends Base
{
    // 获取所有每次登录通知
    public function every_day_all(Request $request)
    {
        $loginNoticeAll = LoginNoticeModel::orderBy("id", "desc")->where('type', '0')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeAll->count();
        $returnData['data']             = $loginNoticeAll->toArray();
        return success($returnData);
    }
}
