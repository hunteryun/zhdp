<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceEventLog as DeviceEventLogModel;
use App\Http\Requests\DeviceEventLog\AddDeviceEventLog as AddDeviceEventLogRequests;
use App\Http\Requests\DeviceEventLog\UpdateDeviceEventLog as UpdateDeviceEventLogRequests;
// 设备事件日志
class DeviceEventLogController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');

        //
        $where = [];
        // 字段事件名称
        if($request->filled('name')){
            $where[] = ['name', 'like', '%'.$request->input('name').'%'];
        }
        // 字段事件类型
        if($request->filled('type')){
            $where[] = ['type', $request->input('type')];
        }

        $deviceList = UserModel::where('token', $this->user_token())->firstOrFail()->device_event_log()->where($where)->whereHas('device', function($query) use($request){
            // 产品
            if($request->filled('product_id')){
                $query->where('product_id', intval($request->input('product_id')));
            }
            // 设备
            if($request->filled('device_id')){
                $query->where('id', intval($request->input('device_id')));
            }
        })->whereHas('device.device_room', function($query) use($request){
            // 区域
            if($request->filled('device_region_id')){
                $query->where('device_region_id', intval($request->input('device_region_id')));
            }
            // 房间
            if($request->filled('device_room_id')){
                $query->where('device_room_id', intval($request->input('device_room_id')));
            }
        })->whereHas('device_field', function($query) use($request){
            // 字段id
            if($request->filled('device_field_id')){
                $query->where('id', intval($request->input('device_field_id')));
            }
        })->with("device", "device_field", "associated_device", "associated_device_field")->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceList['total'];
        $returnData['current_page']     = $deviceList['current_page'];
        $returnData['data']             = $deviceList['data'];
        return success($returnData);
    }
    // 获取单个
    public function show(Request $request, $id){
        $deviceEventLogInfo = DeviceEventLogModel::where("id", $id)->firstOrFail();
        return success(['data'=>$deviceEventLogInfo, 'msg'=>"查询成功"]);
    }
    // 新增
    public function store(Request $request)
    {
        (new AddDeviceEventLogRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $deviceEventLog = new DeviceEventLog;
        $deviceEventLog->user_id               = $user_id;
        $deviceEventLog->name                  = $request->input('name');
        $deviceEventLog->type                  = $request->input('type');
        $deviceEventLog->value                 = $request->input('value');
        $deviceEventLog->desc                  = $request->input('desc');
        $deviceEventLog->device_region_id             = $request->input('device_region_id');
        $deviceEventLog->device_room_id             = $request->input('device_room_id');
        $deviceEventLog->device_id             = $request->input('device_id');
        $deviceEventLog->device_field_id       = $request->input('device_field_id');
        $deviceEventLog->associated_device_id  = $request->input('associated_device_id');
        $deviceEventLog->associated_device_field_id  = $request->input('associated_device_field_id');
        $deviceEventLog->operation_type        = $request->input('operation_type');
        $addArticle = $deviceEventLog->save();
        if(!$addArticle){
            return errors(['msg'=>"设备事件日志创建失败"]);
        }
        return success(['msg'=>"设备事件日志创建成功"]);
    }    
    // 更新
    public function update(Request $request, $id){
        (new UpdateDeviceEventLogRequests)->verification();
        $deviceEventLogInfo = DeviceEventLogModel::where('id', $id)->firstOrFail();
        $deviceEventLogInfo->name                  = $request->input('name');
        $deviceEventLogInfo->type                  = $request->input('type');
        $deviceEventLogInfo->value                 = $request->input('value');
        $deviceEventLogInfo->desc                  = $request->input('desc');
        $deviceEventLogInfo->device_region_id             = $request->input('device_region_id');
        $deviceEventLogInfo->device_room_id             = $request->input('device_room_id');
        $deviceEventLogInfo->device_id             = $request->input('device_id');
        $deviceEventLogInfo->device_field_id       = $request->input('device_field_id');
        $deviceEventLogInfo->associated_device_id  = $request->input('associated_device_id');
        $deviceEventLogInfo->associated_device_field_id  = $request->input('associated_device_field_id');
        $deviceEventLogInfo->operation_type        = $request->input('operation_type');
        $updateDevice = $deviceEventLogInfo->save();
        if(!$updateDevice){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        $deleteDeviceStatus = UserModel::where('token', $this->user_token())->firstOrFail()->device_event_log()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceStatus){
            return errors(['msg'=>"设备事件日志删除失败"]);
        }
        return success(['msg'=>"设备事件日志删除成功"]);
    }
}
