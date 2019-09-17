<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\LoginNotice as LoginNoticeModel;
// 登陆通知
class LoginNoticeController extends Base
{
      // 获取列表(即时通知与每次通知)
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $loginNoticeList = LoginNoticeModel::where('type', '0')->orderBy("id", "desc")->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeList['total'];
        $returnData['current_page']     = $loginNoticeList['current_page'];
        $returnData['data']             = $loginNoticeList['data'];
        return success($returnData);
    }
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
