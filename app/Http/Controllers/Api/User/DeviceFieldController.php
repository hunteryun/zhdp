<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\Device as DeviceModel;
// 设备字段
class DeviceFieldController extends Base
{
    /**
     * 获取所有设备下的所有字段 api/device/device_field/all
     */
    public function all(Request $request)
    {
        // length是前端关键字,所以重命名为lh
        $DeviceFieldAll = DeviceModel::where('id', intval($request->device_id))->firstOrFail()->device_field()->with('field_type')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $DeviceFieldAll->count();
        $returnData['data']             = $DeviceFieldAll->toArray();
        return success(['data'=> $DeviceFieldAll->toArray()]);
    }
}
