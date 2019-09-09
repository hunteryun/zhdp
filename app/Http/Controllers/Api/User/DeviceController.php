<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\Device as DeviceModel;
use App\Model\ProductField as ProductFieldModel;
use App\Model\DeviceField as DeviceFieldModel;
use App\Http\Requests\Device\AddDevice as AddDeviceRequests;
use App\Http\Requests\Device\UpdateDevice as UpdateDeviceRequests;
use DB;
// 设备
class DeviceController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $deviceList = UserModel::where('token', $this->user_token())->firstOrFail()->device()->with('device_room')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceList['total'];
        $returnData['current_page']     = $deviceList['current_page'];
        $returnData['data']             = $deviceList['data'];
        return success($returnData);
    }
    /**
     * 获取房间下的所有设备 api/device/all
     */
    public function all(Request $request)
    {
        // length是前端关键字,所以重命名为lh
        $DeviceFieldAll = UserModel::where('token', $this->user_token())->firstOrFail()->device_room()->where('id', intval($request->device_room_id))->firstOrFail()->device()->with('device_field')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $DeviceFieldAll->count();
        $returnData['data']             = $DeviceFieldAll->toArray();
        return success(['data'=> $DeviceFieldAll->toArray()]);
    }
    // 新增
    public function store(Request $request){
        (new AddDeviceRequests)->verification($request);
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        DB::beginTransaction();
        $deviceModel = new DeviceModel;
        $deviceModel->user_id = $user_id;
        $deviceModel->device_room_id = $request->input('device_room_id');
        $deviceModel->product_id = $request->input('product_id');
        $deviceModel->name = $request->input('name');
        $deviceModel->desc = $request->input('desc');
        $deviceModel->token = str_random(60);
        $addDeviceStatus = $deviceModel->save();
        $device_id = $deviceModel->id;
        $productFieldModel = new ProductFieldModel;
        $productFieldList = $productFieldModel::where('product_id', $request->input('product_id'))->get()->toArray();
        $deviceFieldModel = new DeviceFieldModel;
        foreach($productFieldList as $key => $value){
            $deviceFieldModel->device_id = $device_id;
            $deviceFieldModel->name = $value['name'];
            $deviceFieldModel->field = $value['field'];
            $deviceFieldModel->field_type_id = $value['field_type_id'];
            $deviceFieldModel->field_type_length = $value['field_type_length'];
            $deviceFieldModel->common_field = $value['common_field'];
            $deviceFieldModel->common_field_sort = $value['common_field_sort'];
            $deviceFieldModel->desc = $value['desc'];
            $deviceFieldModel->sort = $value['sort'];
            $addDeviceFieldStatus[$key] = $deviceFieldModel->save();
        }
        if($addDeviceStatus && count(array_unique($addDeviceFieldStatus)) < 2){
            DB::commit();
            return success(['msg'=>'创建成功']);
        }else{
            DB::rollBack();
            return errors(['msg'=>'创建失败']);
        }
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateDeviceRequests)->verification();
        $deviceInfo = DeviceModel::where('id', $id)->firstOrFail();
        $deviceInfo->name = $request->input('name');
        $deviceInfo->desc = $request->input('desc');
        $updateDevice = $deviceInfo->save();
        if(!$updateDevice){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceStatus = DeviceModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceStatus){
            return errors("设备删除失败");
        }
        return success(['msg'=>"设备删除成功"]);
    }
}
