<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\CropTraceability as CropTraceabilityModel;
use App\Model\CropTraceabilityBatch as CropTraceabilityBatchModel;
use App\Http\Requests\CropTraceability\AddCropTraceability as AddCropTraceabilityRequests;
use App\Http\Requests\CropTraceability\UpdateCropTraceability as UpdateCropTraceabilityRequests;
// 作物追溯
class CropTraceabilityController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $where = [];
        if($request->filled('status')){
            $where[] = ['status', strval(intval($request->status))];
        }

        $cropTraceabilityList = UserModel::where('token', $this->user_token())->firstOrFail()->crop_traceability()->where($where)->whereHas('device_room',function($query) use ($request){
            if($request->filled('device_region_id')){
                $query->where('device_region_id', intval($request->device_region_id));
            }
        })->with('device_room', 'crop_class')->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropTraceabilityList['total'];
        $returnData['current_page']     = $cropTraceabilityList['current_page'];
        $returnData['data']             = $cropTraceabilityList['data'];
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddCropTraceabilityRequests)->verification($request);
        $deviceRoomInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $request->device_room_id)->firstOrFail();
        $cropTraceabilityModel = new CropTraceabilityModel;
        $cropTraceabilityModel->user_id = $deviceRoomInfo->user_id;
        $cropTraceabilityModel->device_room_id = $deviceRoomInfo->id;
        $cropTraceabilityModel->crop_class_id = $deviceRoomInfo->crop_class_id;
        $cropTraceabilityModel->crop_variety = $request->input('crop_variety');
        $cropTraceabilityModel->number_of_plants = $request->input('number_of_plants');
        $cropTraceabilityModel->start_time = $request->input('start_time');
        $cropTraceabilityModel->status = '0';
        $addCropTraceability = $cropTraceabilityModel->save();
        if(!$addCropTraceability){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateCropTraceabilityRequests)->verification($request);
        $cropTraceabilityInfo = UserModel::where('token', $this->user_token())->firstOrFail()->crop_traceability()->where('id', $id)->firstOrFail();
        $cropTraceabilityInfo->crop_variety = $request->input('crop_variety');
        $cropTraceabilityInfo->number_of_plants = $request->input('number_of_plants');
        $cropTraceabilityInfo->start_time = $request->input('start_time');
        $updateCropTraceability = $cropTraceabilityInfo->save();
        if(!$updateCropTraceability){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        $deleteCropTraceabilityStatus = UserModel::where('token', $this->user_token())->firstOrFail()->crop_traceability()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteCropTraceabilityStatus){
            return errors("作物追溯删除失败");
        }
        return success(['msg'=>"作物追溯删除成功"]);
    }
    //  http://code9.com:8080/user/crop_traceability/qrcode_info?token=LDCwJhMKYIctA0lZzOxoyYupKutzsesANv9IyvRWBKdJzk3YT0rW5ZOCtI09
    // 根据 收获批次token获取所属大棚，作物信息等
    public function qr_code_crop_traceability_info(Request $request, $token)
    {
        // 收获批次信息
        $cropTraceabilityBatchInfo = CropTraceabilityBatchModel::where('token', $token)->firstOrFail();
        // 获取批次所属追溯
        $cropTraceability = $cropTraceabilityBatchInfo->crop_traceability()->with('device_room', 'device_room.device_region', 'crop_class')->firstOrFail();
        // 获取事件信息
        $cropTraceabilityEventLog = $cropTraceability->crop_traceability_event_log()->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['data']             = [
            'crop_traceability' => $cropTraceabilityBatchInfo,
            'cropTraceability' => $cropTraceability,
            'cropTraceabilityEventLog' => $cropTraceabilityEventLog,
        ];
        return success($returnData);
    }
}
