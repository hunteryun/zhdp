<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\CropTraceabilityBatch as CropTraceabilityBatchModel;
// 作物收获批次
class CropTraceabilityBatchController extends Base
{
    // 作物批次待审核
    public function pending_review(Request $request)
    {
        $limit = $request->input('limit');
        $CropTraceabilityBatchAll = CropTraceabilityBatchModel::where('sampling_status', '0')->with('crop_traceability', 'crop_traceability.device_room', 'crop_traceability.crop_class')->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $CropTraceabilityBatchAll['total'];
        $returnData['current_page']     = $CropTraceabilityBatchAll['current_page'];
        $returnData['data']             = $CropTraceabilityBatchAll['data'];
        return success($returnData);
    }
    // 作物批次审核
    public function review(Request $request, $id){
        $cropTraceabilityBatchInfo = CropTraceabilityBatchModel::where('id', $id)->where('sampling_status', '0')->firstOrFail();
        $cropTraceabilityBatchInfo->sampling_status = strval(intval($request->input('sampling_status')));
        $cropTraceabilityBatchUpdateStatus = $cropTraceabilityBatchInfo->save();
        if($cropTraceabilityBatchUpdateStatus){
            return success(['msg'=>'审核成功']);
        }else{
            return errors(['msg'=>'审核失败']);
        }
    }
    // 作物批次已审核(包括审核通过与未通过)
    public function audited(Request $request)
    {
        $limit = $request->input('limit');
        $CropTraceabilityBatchAll = CropTraceabilityBatchModel::where('sampling_status', '<>', '0')->with('crop_traceability', 'crop_traceability.device_room', 'crop_traceability.crop_class')->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $CropTraceabilityBatchAll['total'];
        $returnData['current_page']     = $CropTraceabilityBatchAll['current_page'];
        $returnData['data']             = $CropTraceabilityBatchAll['data'];
        return success($returnData);
    }
}
