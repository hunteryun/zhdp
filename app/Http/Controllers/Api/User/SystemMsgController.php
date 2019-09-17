<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
// 系统消息
class SystemMsgController extends Base
{
    // 未读 已读 全部
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $systemMsgList = UserModel::where('token', $this->admin_token())->firstOrFail()->system_msg()->orderBy("id", "desc")->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $systemMsgList['total'];
        $returnData['current_page']     = $systemMsgList['current_page'];
        $returnData['data']             = $systemMsgList['data'];
        return success($returnData);
    }
    // 获取单个系统消息
    public function show(Request $request, $id){
        $systemMsgInfo = UserModel::where('token', $this->admin_token())->firstOrFail()->system_msg()->where("id", $id)->firstOrFail();
        // 更新查看状态
        if($systemMsgInfo->status == 0){
            $systemMsgInfo->status = '1';
            $systemMsgInfo->save();
        }
        return success(['data'=>$systemMsgInfo,'msg'=>"查询成功"]);
    }
    
}
