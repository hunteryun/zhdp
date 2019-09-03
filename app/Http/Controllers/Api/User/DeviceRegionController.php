<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceRegion as DeviceRegionModel;
// 设备区域
class DeviceRegionController extends Base
{
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
    public function store(Request $request){
        
        $name = $request->input('name');
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
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
        
        $name = $request->input('name');
        $deviceRegionInfo = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->where('id', $id)->firstOrFail();
        $deviceRegionInfo->name = $name;
        $updateDeviceRegion = $deviceRegionInfo->save();
        if(!$updateDeviceRegion){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }

    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("设备区域删除失败");
        }
        return success(['msg'=>"设备区域删除成功"]);
    }
}
