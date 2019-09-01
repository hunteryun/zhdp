<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceRegion as DeviceRegionModel;
// use App\Model\DeviceRegion as DeviceRegionModel;
// use App\Http\Requests\DeviceRegion\AddDeviceRegion as AddDeviceRegionRequests;
// use App\Http\Requests\DeviceRegion\UpdateDeviceRegion as UpdateDeviceRegionRequests;
// 设备区域
class DeviceRegionController extends Controller
{
    public function index(Request $request)
    {
        $token = $request->input('token');
        $limit = $request->input('limit');
        $deviceRegionList = UserModel::where('token', $token)->firstOrFail()->device_region()->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
    public function store(Request $request){
        $token = $request->input('token');
        $name = $request->input('name');
        $user_id = UserModel::where('token', $token)->firstOrFail(['id'])->id;
        $deviceRegionModel = new DeviceRegionModel;
        $deviceRegionModel->name = $name;
        $deviceRegionModel->user_id = $user_id;
        $addDeviceRegion = $deviceRegionModel->save();
        if(!$addDeviceRegion){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    public function update(Request $request, $id){
        $token = $request->input('token');
        $name = $request->input('name');
        $deviceRegionInfo = UserModel::where('token', $token)->firstOrFail()->device_region()->where('id', $id)->firstOrFail();
        $deviceRegionInfo->name = $name;
        $updateDeviceRegion = $deviceRegionInfo->save();
        if(!$updateDeviceRegion){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }

    public function destroy(Request $request, $id){
        $token = $request->input('token');
        $deleteDeviceRegionStatus = UserModel::where('token', $token)->firstOrFail()->device_region()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("设备区域删除失败");
        }
        return success(['msg'=>"设备区域删除成功"]);
    }
}
