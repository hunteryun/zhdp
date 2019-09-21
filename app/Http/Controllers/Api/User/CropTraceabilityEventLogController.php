<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\CropTraceability as CropTraceabilityModel;
use App\Model\CropTraceabilityEventLog as CropTraceabilityEventLogModel;
use App\Http\Requests\CropTraceabilityEventLog\AddCropTraceabilityEventLog as AddCropTraceabilityEventLogRequests;
// 作物追溯
class CropTraceabilityEventLogController extends Base
{
    // 获取指定房间id下的唯一进行中的追溯所有事件(每个房间只有一个唯一进行中的)
    public function all(Request $request, $id)
    {
        $cropTraceabilityEventLogAll = CropTraceabilityModel::where('id', $id)->firstOrFail()->crop_traceability_event_log()->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropTraceabilityEventLogAll->count();
        $returnData['data']             = $cropTraceabilityEventLogAll->toArray();
        return success(['data'=> $cropTraceabilityEventLogAll->toArray()]);
    }
    // 新增
    public function store(Request $request){
        (new AddCropTraceabilityEventLogRequests)->verification($request);
        $cropTraceabilityInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $request->input('device_room_id'))->firstOrFail()->crop_traceability()->where('status', '0')->firstOrFail();
        $cropTraceabilityEventLogModel = new CropTraceabilityEventLogModel;
        $cropTraceabilityEventLogModel->crop_traceability_id = $cropTraceabilityInfo->id;
        $cropTraceabilityEventLogModel->event_name = $request->input('event_name');
        $cropTraceabilityEventLogModel->event_content = $request->input('event_content');
        $cropTraceabilityEventLogModel->event_time = $request->input('event_time');
        $addCropTraceabilityEventLog = $cropTraceabilityEventLogModel->save();
        if(!$addCropTraceabilityEventLog){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
}
