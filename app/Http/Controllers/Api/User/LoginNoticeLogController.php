<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
// 登陆通知日志
class LoginNoticeLogController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $loginNoticeLogList = UserModel::where('token', $this->admin_token())->firstOrFail()->login_notice_log()->orderBy("id", "desc")->with('login_notice')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeLogList['total'];
        $returnData['current_page']     = $loginNoticeLogList['current_page'];
        $returnData['data']             = $loginNoticeLogList['data'];
        return success($returnData);
    }
    // 获取所有未读的登录通知
    public function unread_all(Request $request)
    {
        $loginNoticeLogAll = UserModel::where('token', $this->admin_token())->firstOrFail()->login_notice_log()->where('status', '0')->orderBy("id", "desc")->with('login_notice')->get();
        // 获取后变为已读
        foreach($loginNoticeLogAll as $row){
            $row->status = '1';
            $row->save();
        }
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeLogAll->count();
        $returnData['data']             = $loginNoticeLogAll->toArray();
        return success($returnData);
    }
    // 获取指定id
    public function show(Request $request, $id)
    {
        $loginNoticeLogInfo = UserModel::where('token', $this->admin_token())->firstOrFail()->login_notice_log()->where('id', $id)->with('login_notice')->firstOrFail();
        // 更新查看状态
        if($loginNoticeLogInfo->status == 0){
            $loginNoticeLogInfo->status = '1';
            $loginNoticeLogInfo->save();
        }
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $loginNoticeLogInfo->toArray();
        return success($returnData);
    }
}
