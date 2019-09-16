<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceEvent as DeviceEventModel;
use App\Http\Requests\DeviceEvent\AddDeviceEvent as AddDeviceEventRequests;
use App\Http\Requests\DeviceEvent\UpdateDeviceEvent as UpdateDeviceEventRequests;
// 设备事件
class DeviceEventController extends Base
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
        $deviceList = UserModel::where('token', $this->user_token())->firstOrFail()->device_event()->where($where)->whereHas('device', function($query) use($request){
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
            // 字段名
            if($request->filled('device_field_name')){
                $query->where('name', 'like', '%'.$request->input('device_field_name').'%');
            }
            // 字段标识
            if($request->filled('device_field_field')){
                $query->where('field', 'like', '%'.$request->input('device_field_field').'%');
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
        $deviceEventInfo = DeviceEventModel::where("id", $id)->firstOrFail();
        return success(['data'=>$deviceEventInfo, 'msg'=>"查询成功"]);
    }
    // 新增
    public function store(Request $request)
    {
        (new AddDeviceEventRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $deviceEvent = new DeviceEventModel;
        $deviceEvent->user_id               = $user_id;
        $deviceEvent->name                  = $request->input('name');
        $deviceEvent->type                  = $request->input('type');
        $deviceEvent->value                 = $request->input('value');
        $deviceEvent->desc                  = $request->input('desc');
        $deviceEvent->device_region_id             = $request->input('device_region_id');
        $deviceEvent->device_room_id             = $request->input('device_room_id');
        $deviceEvent->device_id             = $request->input('device_id');
        $deviceEvent->device_field_id       = $request->input('device_field_id');
        $deviceEvent->associated_device_id  = $request->input('associated_device_id');
        $deviceEvent->associated_device_field_id  = $request->input('associated_device_field_id');
        $deviceEvent->operation_type        = $request->input('operation_type');
        $addArticle = $deviceEvent->save();
        if(!$addArticle){
            return errors(['msg'=>"设备事件创建失败"]);
        }
        return success(['msg'=>"设备事件创建成功"]);
    }    
    // 更新
    public function update(Request $request, $id){
        (new UpdateDeviceEventRequests)->verification();
        $deviceEventInfo = DeviceEventModel::where('id', $id)->firstOrFail();
        $deviceEventInfo->name                  = $request->input('name');
        $deviceEventInfo->type                  = $request->input('type');
        $deviceEventInfo->value                 = $request->input('value');
        $deviceEventInfo->desc                  = $request->input('desc');
        $deviceEventInfo->device_region_id             = $request->input('device_region_id');
        $deviceEventInfo->device_room_id             = $request->input('device_room_id');
        $deviceEventInfo->device_id             = $request->input('device_id');
        $deviceEventInfo->device_field_id       = $request->input('device_field_id');
        $deviceEventInfo->associated_device_id  = $request->input('associated_device_id');
        $deviceEventInfo->associated_device_field_id  = $request->input('associated_device_field_id');
        $deviceEventInfo->operation_type        = $request->input('operation_type');
        $updateDevice = $deviceEventInfo->save();
        if(!$updateDevice){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        $deleteDeviceStatus = UserModel::where('token', $this->user_token())->firstOrFail()->device_event()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceStatus){
            return errors(['msg'=>"设备事件删除失败"]);
        }
        return success(['msg'=>"设备事件删除成功"]);
    }
}
