<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceRoom as DeviceRoomModel;
use App\Http\Requests\DeviceRoom\AddDeviceRoom as AddDeviceRoomRequests;
use App\Http\Requests\DeviceRoom\UpdateDeviceRoom as UpdateDeviceRoomRequests;
// 设备房间
class DeviceRoomController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $deviceRegionList = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->with('device_region','crop_class')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
    // 获取所有
    public function all()
    {
        $deviceRegionAll = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionAll->count();
        $returnData['data']             = $deviceRegionAll->toArray();
        return success($returnData);
    }
    // 新增
     public function store(Request $request)
    {
        (new AddDeviceRoomRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $deviceRoomModel = new DeviceRoomModel;
        $deviceRoomModel->user_id          = $user_id;
        $deviceRoomModel->device_region_id = $request->input('device_region_id');
        $deviceRoomModel->crop_class_id       = $request->input('crop_class_id');
        $deviceRoomModel->name             = $request->input('name');
        $deviceRoomModel->desc             = $request->input('desc');
        $deviceRoomModel->token            = str_random(60); // token 禁止更新
        $addDeviceRoom = $deviceRoomModel->save();
        if(!$addDeviceRoom){
            return errors(['msg'=>"设备房间创建失败"]);
        }
        return success(['msg'=>"设备房间创建成功"]);
    }      
    // 获取指定id 
      public function show($id)
    {
        $deviceRoomInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $id)->with('device_region')->firstOrFail();
        return success(['msg' => '设备房间查询成功','data' => $deviceRoomInfo]);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateDeviceRoomRequests)->verification();
        $deviceRoomInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $id)->firstOrFail();
        $deviceRoomInfo->device_region_id = $request->input('device_region_id');
        $deviceRoomInfo->crop_class_id       = $request->input('crop_class_id');
        $deviceRoomInfo->name             = $request->input('name');
        $deviceRoomInfo->desc             = $request->input('desc');
        $updateDeviceRoom = $deviceRoomInfo->save();
        if(!$updateDeviceRoom){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("设备房间删除失败");
        }
        return success(['msg'=>"设备房间删除成功"]);
    }
}
