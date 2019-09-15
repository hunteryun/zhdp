<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
// 病虫害预警
class PestWarningLogController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $PestWarningLogList = UserModel::where('token', $this->user_token())->firstOrFail()->pest_warning_log()->with("pest_warning")->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $PestWarningLogList['total'];
        $returnData['current_page']     = $PestWarningLogList['current_page'];
        $returnData['data']             = $PestWarningLogList['data'];
        return success($returnData);
    }
    // 获取单个预警信息
    public function show(Request $request, $id){
        $pestWarningLogInfo = UserModel::where('token', $this->user_token())->firstOrFail()->pest_warning_log()->where("id", $id)->with("pest_warning")->firstOrFail();
        // 更新查看状态
        if($pestWarningLogInfo->status == 0){
            $pestWarningLogInfo->status = '1';
            $pestWarningLogInfo->save();
        }
        return success(['data'=>$pestWarningLogInfo,'msg'=>"查询成功"]);
    }
}
