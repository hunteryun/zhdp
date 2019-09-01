<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
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
        $deviceRegionList = (new UserModel)->where('token', $token)->first()->device_region()->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
}
