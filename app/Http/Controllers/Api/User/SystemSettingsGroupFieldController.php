<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\SystemSettingsGroupField as SystemSettingsGroupFieldModel;
use App\Http\Requests\SystemSettingsGroupField\AddSystemSettingsGroupField as AddSystemSettingsGroupFieldRequests;
use App\Http\Requests\SystemSettingsGroupField\UpdateSystemSettingsGroupField as UpdateSystemSettingsGroupFieldRequests;
// 系统设置字段
class SystemSettingsGroupFieldController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $deviceRegionList = SystemSettingsGroupFieldModel::orderBy('id', 'desc')->with('system_settings_group')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
    // 获取指定id 
    public function show($id)
    {
        $systemSettingsGroupFieldInfo = SystemSettingsGroupFieldModel::where('id', $id)->with('system_settings_group')->firstOrFail();
        return success(['msg' => '系统设置字段查询成功','data' => $systemSettingsGroupFieldInfo]);
    }
    // 新增
     public function store(Request $request)
    {
        (new AddSystemSettingsGroupFieldRequests)->verification();
        $systemSettingsGroupFieldModel = new SystemSettingsGroupFieldModel;
        $systemSettingsGroupFieldModel->system_settings_group_id          = $request->input('system_settings_group_id');
        $systemSettingsGroupFieldModel->name        = $request->input('name');
        $systemSettingsGroupFieldModel->field       = $request->input('field');
        $systemSettingsGroupFieldModel->desc        = $request->input('desc');
        $systemSettingsGroupFieldModel->type        = $request->input('type');
        $systemSettingsGroupFieldModel->option      = $request->input('option');
        $systemSettingsGroupFieldModel->value       = $request->input('value');
        $addSystemSettingsGroupField = $systemSettingsGroupFieldModel->save();
        if(!$addSystemSettingsGroupField){
            return errors(['msg'=>"系统设置字段创建失败"]);
        }
        return success(['msg'=>"系统设置字段创建成功"]);
    }      
    // 更新
    public function update(Request $request, $id){
        (new UpdateSystemSettingsGroupFieldRequests)->verification();
        $systemSettingsGroupFieldInfo = SystemSettingsGroupFieldModel::where('id', $id)->firstOrFail();
        $systemSettingsGroupFieldInfo->system_settings_group_id          = $request->input('system_settings_group_id');
        $systemSettingsGroupFieldInfo->name        = $request->input('name');
        $systemSettingsGroupFieldInfo->field       = $request->input('field');
        $systemSettingsGroupFieldInfo->desc        = $request->input('desc');
        $systemSettingsGroupFieldInfo->type        = $request->input('type');
        $systemSettingsGroupFieldInfo->option      = $request->input('option');
        $systemSettingsGroupFieldInfo->value       = $request->input('value');
        $updateSystemSettingsGroupField = $systemSettingsGroupFieldInfo->save();
        if(!$updateSystemSettingsGroupField){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = SystemSettingsGroupFieldModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("系统设置字段删除失败");
        }
        return success(['msg'=>"系统设置字段删除成功"]);
    }
}
