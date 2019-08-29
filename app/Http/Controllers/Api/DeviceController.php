<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Device as DeviceModel;
use App\Http\Requests\Device\AddDevice as AddDeviceRequests;
use App\Http\Requests\Device\UpdateDevice as UpdateDeviceRequests;
// 设备
class DeviceController extends Controller
{
    /**
     * 获取设备列表 api/Device?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deviceList = (new DeviceModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $deviceList['total'];
        $returnData['current_page']     = $deviceList['current_page'];
        $returnData['data']             = $deviceList['data'];
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建设备
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (new AddDeviceRequests)->verification($request);
        $addDeviceStatus = (new DeviceModel)->addDevice($request);
        if(!$addDeviceStatus){
            return errors(['msg'=>"设备创建失败"]);
        }
        return success(['msg'=>"设备创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deviceInfo = (new DeviceModel)->getFind($id);
        if(!$deviceInfo){
            return errors(['msg'=>"设备不存在"]);
        }
        return success(['msg' => '设备查询成功','data' => $deviceInfo]);
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
        (new UpdateDeviceRequests)->verification();
        $updateDeviceStatus = (new DeviceModel)->updateDevice($request, $id);
        if(!$updateDeviceStatus){
            return errors("设备更新失败");
        }
        return success(['msg'=>"设备更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteDeviceStatus = (new DeviceModel())->deleteDevice($id);
        if(!$deleteDeviceStatus){
            return errors("设备删除失败");
        }
        return success(['msg'=>"设备删除成功"]);
    }
}
