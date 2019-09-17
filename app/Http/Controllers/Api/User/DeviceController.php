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
use App\Services\UpdateDevice;
// 设备
class DeviceController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');

        $where = [];
        // 产品
        if($request->filled('product_id')){
            $where['product_id'] = intval($request->input('product_id'));
        }
        // 设备id
        if($request->filled('id')){
            $where['id'] = intval($request->input('id'));
        }

        $deviceList = UserModel::where('token', $this->admin_token())->firstOrFail()->device()->where($where)->orderBy('id', 'desc')->whereHas('device_room', function($query) use($request){
            // 区域
            if($request->filled('device_region_id')){
                $query->where('device_region_id', intval($request->input('device_region_id')));
            }
            // 房间
            if($request->filled('device_room_id')){
                $query->where('device_room_id', intval($request->input('device_room_id')));
            }
        })->with('device_room')->paginate($limit)->toArray();
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
        $DeviceFieldAll = UserModel::where('token', $this->admin_token())->firstOrFail()->device_room()->where('id', intval($request->device_room_id))->firstOrFail()->device()->orderBy('id', 'desc')->with('device_field')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $DeviceFieldAll->count();
        $returnData['data']             = $DeviceFieldAll->toArray();
        return success(['data'=> $DeviceFieldAll->toArray()]);
    }
    // 新增
    public function store(Request $request){
        (new AddDeviceRequests)->verification($request);
        $user_id = UserModel::where('token', $this->admin_token())->firstOrFail(['id'])->id;
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
        $deviceInsertData = [];
        $date_time = date("Y-m-d H:i:s", time());
        foreach($productFieldList as $key => $value){
            $row = [];
            $row["device_id"] = $device_id;
            $row["name"] = $value['name'];
            $row["field"] = $value['field'];
            $row["field_type_id"] = $value['field_type_id'];
            $row["field_type_length"] = $value['field_type_length'];
            $row["common_field"] = $value['common_field'];
            $row["common_field_sort"] = $value['common_field_sort'];
            $row["desc"] = $value['desc'];
            $row["sort"] = $value['sort'];
            $row["created_at"] = $date_time;
            $row["updated_at"] = $date_time;
            $deviceInsertData[] = $row;
        }
        if($addDeviceStatus && (new DeviceFieldModel)->insert($deviceInsertData)){
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
    // 按照token获取设备字段
    // 默认返回全部字段
    public function getDeviceField(Request $request, $token){
        $deviceFieldList = UserModel::where('token', $this->admin_token())->firstOrFail()->device()->where('token', $token)->firstOrFail()->device_field()->get(['field','value']);
        if($request->filled('field')){
            // 字段以逗号分隔 field => 'top,bottom,...';
            $getField = $request->field;
            $getField = explode(',', $getField);
            $returnData = [];
            foreach($getField as $field){
                foreach($deviceFieldList as $row){
                    if($row->field == $field){
                        $returnData[][$row->field] = $row->value;
                    }
                }
            }
            return success(['data'=>$returnData]);
        }else{
            return success(['data'=>$deviceFieldList]);
        }
    }
    // 按照token更新设备字段
    public function updateDeviceField(Request $request, $token){
        $user_token = $this->admin_token();
        return (new UpdateDevice)->updateDeviceField($request, $user_token, $token);
    }
}
