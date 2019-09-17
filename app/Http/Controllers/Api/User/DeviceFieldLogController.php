<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
// 设备字段日志
class DeviceFieldLogController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');

        $where = [];
        // 字段名称
        if($request->filled('name')){
            $where[] = ['name', 'like', '%'.$request->name.'%'];
        }
        // 字段标识符
        if($request->filled('field')){
            $where[] = ['field', 'like', '%'.$request->field.'%'];
        }
        // 设备id
        if($request->filled('device_id')){
            $where['device_id'] = intval($request->device_id);
        }

        $deviceFieldLogList = UserModel::where('token', $this->admin_token())->firstOrFail()->device_field_log()->where($where)->whereHas('device', function($query) use($request){
            // 产品
            if($request->filled('product_id')){
                $query->where('product_id', intval($request->input('product_id')));
            }
        })->whereHas('device.device_room', function($query) use($request){
            // 区域
            if($request->filled('device_region_id')){
                $query->where('device_region_id', intval($request->input('device_region_id')));
            }
            // 房间
            if($request->filled('device_room_id')){
                $query->where('device_room_id', intval($request->input('device_room_id')));
            }
        })->with('field_type', 'device', 'device.device_room')->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceFieldLogList['total'];
        $returnData['current_page']     = $deviceFieldLogList['current_page'];
        $returnData['data']             = $deviceFieldLogList['data'];
        return success($returnData);
    }
}
