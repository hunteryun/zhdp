<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
// 数据分析
class DataAnalysisController extends Base
{
    // 数据可视化
    // 通过搜索 区域->房间->设备 搜索该设备的数据走向
    public function visualization(Request $request){
        $where = [];
        // 产品
        if($request->filled('product_id')){
            $where['product_id'] = intval($request->input('product_id'));
        }
        // 设备id
        if($request->filled('id')){
            $where['id'] = intval($request->input('id'));
        }

        $deviceList = UserModel::where('token', $this->user_token())->firstOrFail()->device()->where($where)->orderBy('id', 'desc')->whereHas('device_room', function($query) use($request){
            // 区域
            if($request->filled('device_region_id')){
                $query->where('device_region_id', intval($request->input('device_region_id')));
            }else{
                return errors(['msg'=>"请选择区域"]);
            }
            // 房间
            if($request->filled('device_room_id')){
                $query->where('device_room_id', intval($request->input('device_room_id')));
            }else{
                return errors(['msg'=>"请选择房间"]);
            }
        })->whereHas('device_field.field_type', function($query) use($request){
            // 不是布尔值的设备
            $query->where('name', '<>', 'bool');

        })->with('device_field', 'device_field.device_field_log')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']             = count($deviceList);
        $returnData['data']             = $deviceList;
        return success($returnData);
    }
    // 数据大屏
    // 显示设备数量，分布区域，权重，报警记录，我的评论，我的文章，我的收藏，
    public function big_screen(Request $request){

    }

}
