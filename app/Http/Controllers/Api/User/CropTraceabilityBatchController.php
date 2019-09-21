<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\CropTraceability as CropTraceabilityModel;
use App\Model\CropTraceabilityBatch as CropTraceabilityBatchModel;
use App\Http\Requests\CropTraceabilityBatch\AddCropTraceabilityBatch as AddCropTraceabilityBatchRequests;
use \QrCode;
// 作物收获批次
class CropTraceabilityBatchController extends Base
{
    // 获取指定房间id下的唯一进行中的追溯所有事件(每个房间只有一个唯一进行中的)
    public function all(Request $request, $id)
    {
        $CropTraceabilityBatchAll = CropTraceabilityModel::where('id', $id)->firstOrFail()->crop_traceability_batch()->get();
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

        QrCode::format('png');
        QrCode::size(1000);
        QrCode::generate(url('user/crop_traceability/qrcode_info?token='.$CropTraceabilityBatchModel->token), '../storage/app/public/qrcode/'.$CropTraceabilityBatchModel->token.'.svg');
        
        $file_path = '/storage/qrcode/'.$CropTraceabilityBatchModel->token.'.svg';
        $CropTraceabilityBatchModel->qr_code_path = $file_path;
        // 大棚状态 如果等于1则种植结束
        if($request->filled('status') && intval($request->input('status')) == 1){
            $cropTraceabilityInfo->end_time = $request->input('end_time');
            $cropTraceabilityInfo->status = '1';
            $cropTraceabilityInfo->save();
        }
        $addCropTraceabilityBatch = $CropTraceabilityBatchModel->save();
        if(!$addCropTraceabilityBatch){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 作物批次待审核
    public function pending_review(Request $request)
    {
        $limit = $request->input('limit');
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail()->id;
        
        $CropTraceabilityBatchAll = CropTraceabilityBatchModel::where('sampling_status', '0')->whereHas('crop_traceability', function($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->with('crop_traceability', 'crop_traceability.device_room', 'crop_traceability.crop_class')->orderBy('id', 'desc')->paginate($limit)->toArray();
        
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $CropTraceabilityBatchAll['total'];
        $returnData['current_page']     = $CropTraceabilityBatchAll['current_page'];
        $returnData['data']             = $CropTraceabilityBatchAll['data'];
        return success($returnData);
    }
    // 作物批次已审核(包括审核通过与未通过)
    public function audited(Request $request)
    {
        $limit = $request->input('limit');
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail()->id;
        
        $CropTraceabilityBatchAll = CropTraceabilityBatchModel::where('sampling_status', '<>', '0')->whereHas('crop_traceability', function($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->with('crop_traceability', 'crop_traceability.device_room', 'crop_traceability.crop_class')->orderBy('id', 'desc')->paginate($limit)->toArray();

        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $CropTraceabilityBatchAll['total'];
        $returnData['current_page']     = $CropTraceabilityBatchAll['current_page'];
        $returnData['data']             = $CropTraceabilityBatchAll['data'];
        return success($returnData);
    }
}
