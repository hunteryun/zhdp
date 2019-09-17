<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceRegion as DeviceRegionModel;
use App\Http\Requests\DeviceRegion\AddDeviceRegion as AddDeviceRegionRequests;
use App\Http\Requests\DeviceRegion\UpdateDeviceRegion as UpdateDeviceRegionRequests;
// 设备区域
class DeviceRegionController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $deviceRegionList = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->paginate($limit)->toArray();
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
        $deviceRegionAll = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->with('device_room')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionAll->count();
        $returnData['data']             = $deviceRegionAll->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddDeviceRegionRequests)->verification($request);
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $deviceRegionModel = new DeviceRegionModel;
        $deviceRegionModel->user_id = $user_id;
        $deviceRegionModel->name = $request->input('name');
        $deviceRegionModel->province = $request->input('province');
        $deviceRegionModel->city = $request->input('city');
        $deviceRegionModel->area = $request->input('area');
        $addDeviceRegion = $deviceRegionModel->save();
        if(!$addDeviceRegion){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateDeviceRegionRequests)->verification($request);
        $deviceRegionInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->where('id', $id)->firstOrFail();
        $deviceRegionInfo->name = $request->input('name');
        $deviceRegionInfo->province = $request->input('province');
        $deviceRegionInfo->city = $request->input('city');
        $deviceRegionInfo->area = $request->input('area');
        $updateDeviceRegion = $deviceRegionInfo->save();
        if(!$updateDeviceRegion){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("设备区域删除失败");
        }
        return success(['msg'=>"设备区域删除成功"]);
    }
}
