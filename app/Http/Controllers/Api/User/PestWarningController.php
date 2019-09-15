<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\PestWarning as PestWarningModel;
use App\Model\PestWarningLog as PestWarningLogModel;
use App\Http\Requests\PestWarning\AddPestWarning as AddPestWarningRequests;
use App\Http\Requests\PestWarning\UpdatePestWarning as UpdatePestWarningRequests;
// 病虫害预警
class PestWarningController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $pestWarningList = PestWarningModel::paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $pestWarningList['total'];
        $returnData['current_page']     = $pestWarningList['current_page'];
        $returnData['data']             = $pestWarningList['data'];
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddPestWarningRequests)->verification($request);
        $pestWarningModel = new PestWarningModel;
        $pestWarningModel->title = $request->input('title');
        $pestWarningModel->type = $request->input('type');
        if($request->has('start_time')){
            $pestWarningModel->start_time = $request->input('start_time');
        }
        if($request->has('end_time')){
            $pestWarningModel->end_time = $request->input('end_time');
        }
        $pestWarningModel->warning = $request->input('warning');
        $pestWarningModel->content = $request->input('content');
        $addPestWarning = $pestWarningModel->save();
        $pest_warning_id = $pestWarningModel->id;
        // 写入日志
        $date_time = date("Y-m-d H:i:s", time()); 
        UserModel::chunk(100, function ($users) use ($pest_warning_id, $date_time){
            $logs = [];
            foreach ($users as $user) {
                $log = [];
                $log['pest_warning_id'] = $pest_warning_id;
                $log['user_id'] = $user->id;
                $log['status'] = '0';
                $log['updated_at'] = $date_time;
                $log['created_at'] = $date_time;
                $logs[] = $log;
            }
            PestWarningLogModel::insert($logs);
        });
        
        if(!$addPestWarning){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdatePestWarningRequests)->verification();
        $pestWarningInfo = PestWarningModel::where('id', $id)->firstOrFail();
        $pestWarningInfo->title = $request->input('title');
        $pestWarningInfo->type = $request->input('type');
        if($request->has('start_time')){
            $pestWarningInfo->start_time = $request->input('start_time');
        }
        if($request->has('end_time')){
            $pestWarningInfo->end_time = $request->input('end_time');
        }
        $pestWarningInfo->warning = $request->input('warning');
        $pestWarningInfo->content = $request->input('content');
        $updatePestWarning = $pestWarningInfo->save();
        if(!$updatePestWarning){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deletePestWarningStatus = PestWarningModel::where('id', $id)->firstOrFail()->delete();
        if(!$deletePestWarningStatus){
            return errors("病虫害预警删除失败");
        }
        return success(['msg'=>"病虫害预警删除成功"]);
    }
}
