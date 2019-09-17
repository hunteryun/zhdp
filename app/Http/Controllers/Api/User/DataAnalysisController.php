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

        })->with(['device_field', 'device_field.device_field_log' => function($query) use($request){
            // 时间
            $time = floatval($request->input('time'));
            if($time > 8760){
                $time = 8760;
            }else if($time < 0.5){
                $time = 0.5;
            }
            // 查询时间区间 
            $query->whereBetween('created_at',[date("Y-m-d H:i:s", time() - ($time * 3600)),date("Y-m-d H:i:s", time())]);
            $query->select("*");
            if($time <= 5){
                $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i') as date");
            }else if($time <= 720){
                $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H') as date");
            }else if($time <= 8760){
                $query->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date");
            }
            $query->groupBy('date');
            $query->orderBy('date', 'desc');
        }])->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']             = count($deviceList);
        $returnData['data']             = $deviceList;
        return success($returnData);
    }
    // 数据大屏
    // 设备数量分布(all) 本周请求次数(天) 设备事件(24h) 设备事件分类
    public function big_screen(Request $request){
        // 获取数量分区
        $deviceList = UserModel::where('token', $this->user_token())->firstOrFail()->device_region()->with(['device_room.device'=>function($query){
            $query->selectRaw('count(id) as device_num,device_room_id');
            $query->groupBy('device_room_id');
        }])->get(['id','name']);

        // 组装设备分布
        $deviceRegion = [];
        // 区域列表
        foreach($deviceList as $value){
            $row = [];
            $row['name'] = $value['name'];
            $row['device_num'] = 0;
            // 房间列表
            foreach($value['device_room'] as $val){
                // 设备列表
                foreach($val['device'] as $v){
                    $row['device_num'] += $v['device_num'];
                }   
            }
            $deviceRegion[] = $row;
        }

        // 获取本周请求次数，按照天进行分组
        $startTime = date("Y-m-d", strtotime("-7 day"));
        $endTime = date("Y-m-d", time());
        $deviceFieldLogDayList = UserModel::where('token', $this->user_token())->firstOrFail()->device_field_log()
            ->whereBetween('created_at',[$startTime, $endTime])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d') as date,COUNT(id) as num")
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        // dd($deviceFieldLogDayList->toArray());


        // 获取设备事件(按小时分组)
        $deviceEventLogList = UserModel::where('token', $this->user_token())->firstOrFail()->device_event_log()
            ->whereBetween('created_at',[date("Y-m-d H:i:s", strtotime("-1 day")), date('Y-m-d H:i:s', time())])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m-%d %H') as date,COUNT(id) as num")
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        // dd($deviceEventLogList->toArray());



        // 获取24小时设备事件分类
        $deviceEventLogClassList = UserModel::where('token', $this->user_token())->firstOrFail()->device_event_log()
            ->whereBetween('created_at',[date("Y-m-d H:i:s", strtotime("-1 day")), date('Y-m-d H:i:s', time())])
            ->selectRaw("COUNT(id) as num,type")
            ->groupBy('type')
            ->orderBy('type', 'desc')
            ->get();
        // dd( $deviceEventLogClassList->toArray());
        $returnData = [];
        $returnData['deviceRegion'] = $deviceRegion;
        $returnData['deviceFieldLogDayList'] = $deviceFieldLogDayList;
        $returnData['deviceEventLogList'] = $deviceEventLogList;
        $returnData['deviceEventLogClassList'] = $deviceEventLogClassList;
        return success(['data'=>$returnData]);
    }

}
