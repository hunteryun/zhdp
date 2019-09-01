<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\DeviceRegion as DeviceRegionModel;
use App\Http\Requests\DeviceRegion\AddDeviceRegion as AddDeviceRegionRequests;
use App\Http\Requests\DeviceRegion\UpdateDeviceRegion as UpdateDeviceRegionRequests;
// 设备区域
class DeviceRegionController extends Controller
{
    /**
     * 获取设备区域列表 api/device_region?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deviceRegionList = (new DeviceRegionModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }

    /**
     * 获取所有设备区域 api/device_region/all
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $deviceRegionAll = (new DeviceRegionModel)->getAll($request);
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $deviceRegionAll;
        $returnData['total']            = $deviceRegionAll->count();
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建设备区域
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (new AddDeviceRegionRequests)->verification();
        $addDeviceRegion = (new DeviceRegionModel)->addDeviceRegion($request);
        if(!$addDeviceRegion){
            return errors(['msg'=>"设备区域创建失败"]);
        }
        return success(['msg'=>"设备区域创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deviceRegionInfo = (new DeviceRegionModel)->getFind($id);
        return success(['msg' => '设备区域查询成功','data' => $deviceRegionInfo]);
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
        (new UpdateDeviceRegionRequests)->verification();
        $updateDeviceRegionStatus = (new DeviceRegionModel)->updateDeviceRegion($request, $id);
        if(!$updateDeviceRegionStatus){
            return errors("设备区域更新失败");
        }
        return success(['msg'=>"设备区域更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteDeviceRegionStatus = (new DeviceRegionModel())->deleteDeviceRegion($id);
        if(!$deleteDeviceRegionStatus){
            return errors("设备区域删除失败");
        }
        return success(['msg'=>"设备区域删除成功"]);
    }
}
