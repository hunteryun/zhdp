<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DeviceField as DeviceFieldModel;
use App\Http\Requests\DeviceField\AddDeviceField as AddDeviceFieldRequests;
use App\Http\Requests\DeviceField\UpdateDeviceField as UpdateDeviceFieldRequests;
// 设备字段
class DeviceFieldController extends Controller
{
    /**
     * 获取设备字段列表 api/device_field?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deviceFieldList = (new DeviceFieldModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $deviceFieldList['total'];
        $returnData['current_page']     = $deviceFieldList['current_page'];
        $returnData['data']             = $deviceFieldList['data'];
        return success($returnData);
    }

    /**
     * 获取所有设备字段 api/device_field/all
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $deviceFieldAll = (new DeviceFieldModel)->getAll($request);
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $deviceFieldAll;
        $returnData['total']            = $deviceFieldAll->count();
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建设备字段
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (new AddDeviceFieldRequests)->verification();
        $addDeviceField = (new DeviceFieldModel)->addDeviceField($request);
        if(!$addDeviceField){
            return errors(['msg'=>"设备字段创建失败"]);
        }
        return success(['msg'=>"设备字段创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deviceFieldInfo = (new DeviceFieldModel)->getFind($id);
        return success(['msg' => '设备字段查询成功','data' => $deviceFieldInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        (new UpdateDeviceFieldRequests)->verification();
        $updateDeviceFieldStatus = (new DeviceFieldModel)->updateDeviceField($request, $id);
        if(!$updateDeviceFieldStatus){
            return errors("设备字段更新失败");
        }
        return success(['msg'=>"设备字段更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteDeviceFieldStatus = (new DeviceFieldModel())->deleteDeviceField($id);
        if(!$deleteDeviceFieldStatus){
            return errors("设备字段删除失败");
        }
        return success(['msg'=>"设备字段删除成功"]);
    }
}
