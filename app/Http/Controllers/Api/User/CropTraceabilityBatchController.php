<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\CropTraceabilityBatch as CropTraceabilityBatchModel;
use App\Http\Requests\CropTraceabilityBatch\AddCropTraceabilityBatch as AddCropTraceabilityBatchRequests;
// 作物收获批次
class CropTraceabilityBatchController extends Base
{
    // 获取指定房间id下的唯一进行中的追溯所有事件(每个房间只有一个唯一进行中的)
    public function all(Request $request, $device_room_id)
    {
        $CropTraceabilityBatchAll = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $device_room_id)->firstOrFail()->crop_traceability()->firstOrFail()->crop_traceability_batch()->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $CropTraceabilityBatchAll->count();
        $returnData['data']             = $CropTraceabilityBatchAll->toArray();
        return success(['data'=> $CropTraceabilityBatchAll->toArray()]);
    }
    // 新增
    public function store(Request $request){
        (new AddCropTraceabilityBatchRequests)->verification($request);
        $cropTraceabilityInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $request->input('device_room_id'))->firstOrFail()->crop_traceability()->where('status', '0')->firstOrFail();
        $CropTraceabilityBatchModel = new CropTraceabilityBatchModel;
        $CropTraceabilityBatchModel->crop_traceability_id = $cropTraceabilityInfo->id;
        $CropTraceabilityBatchModel->token = str_random(60);
        $CropTraceabilityBatchModel->batch = $cropTraceabilityInfo->crop_traceability_batch()->count() + 1;
        $CropTraceabilityBatchModel->harvest_quantity = $request->input('harvest_quantity');
        $CropTraceabilityBatchModel->end_time = $request->input('end_time');
        $CropTraceabilityBatchModel->sampling_status = '0';
        $CropTraceabilityBatchModel->qr_code_path = '';
        // 大棚状态 如果等于1则种植结束
        if($request->filled('status') && intval($request->input('status')) == 1){
            $cropTraceabilityInfo->end_time = date("Y-m-d H:i:s", time());
            $cropTraceabilityInfo->status = '1';
            $cropTraceabilityInfo->save();
        }
        $addCropTraceabilityBatch = $CropTraceabilityBatchModel->save();
        if(!$addCropTraceabilityBatch){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
}
