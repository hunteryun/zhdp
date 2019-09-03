<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\DeviceRoom as DeviceRoomModel;
use App\Http\Requests\DeviceRoom\AddDeviceRoom as AddDeviceRoomRequests;
// 设备房间
class DeviceRoomController extends Base
{
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $deviceRegionList = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
     public function store(Request $request)
    {
        (new AddDeviceRoomRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $deviceRoomModel = new DeviceRoomModel;
        $deviceRoomModel->user_id          = $user_id;
        $deviceRoomModel->device_region_id = $request->input('device_region_id');
        $deviceRoomModel->name             = $request->input('name');
        $deviceRoomModel->desc             = $request->input('desc');
        $deviceRoomModel->token            = getOnlyToken_60(); // token 禁止更新
        $addDeviceRoom = $deviceRoomModel->save();
        if(!$addDeviceRoom){
            return errors(['msg'=>"设备房间创建失败"]);
        }
        return success(['msg'=>"设备房间创建成功"]);
    }       

    // /**
    //  * 获取设备房间列表 api/device_room?page=2&limit=2
    //  * @param $page 页码
    //  * @param $limit 数量
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index(Request $request)
    // {
    //     $deviceRoomList = (new DeviceRoomModel)->getPaginate($request);
    //     $returnData = [];
    //     $returnData['msg']              = "查询成功";
    //     $returnData['count']            = $deviceRoomList['total'];
    //     $returnData['current_page']     = $deviceRoomList['current_page'];
    //     $returnData['data']             = $deviceRoomList['data'];
    //     return success($returnData);
    // }

    // /**
    //  * 获取所有设备房间 api/device_room/all
    //  * @return \Illuminate\Http\Response
    //  */
    // public function all(Request $request)
    // {
    //     $deviceRoomAll = (new DeviceRoomModel)->getAll($request);
    //     $returnData['msg']              = "查询成功";
    //     $returnData['data']             = $deviceRoomAll;
    //     $returnData['total']            = $deviceRoomAll->count();
    //     return success($returnData);
    //     // return 
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  * --------
    //  * 创建设备房间
    //  * --------
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     (new AddDeviceRoomRequests)->verification();
    //     $addDeviceRoom = (new DeviceRoomModel)->addDeviceRoom($request);
    //     if(!$addDeviceRoom){
    //         return errors(['msg'=>"设备房间创建失败"]);
    //     }
    //     return success(['msg'=>"设备房间创建成功"]);
    // }       

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     $deviceRoomInfo = (new DeviceRoomModel)->getFind($id);
    //     return success(['msg' => '设备房间查询成功','data' => $deviceRoomInfo]);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     (new UpdateDeviceRoomRequests)->verification();
    //     $updateDeviceRoomStatus = (new DeviceRoomModel)->updateDeviceRoom($request, $id);
    //     if(!$updateDeviceRoomStatus){
    //         return errors("设备房间更新失败");
    //     }
    //     return success(['msg'=>"设备房间更新成功"]);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $deleteDeviceRoomStatus = (new DeviceRoomModel())->deleteDeviceRoom($id);
    //     if(!$deleteDeviceRoomStatus){
    //         return errors("设备房间删除失败");
    //     }
    //     return success(['msg'=>"设备房间删除成功"]);
    // }
}
