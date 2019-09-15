<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\SystemSettingsGroup as SystemSettingsGroupModel;
use App\Http\Requests\SystemSettingsGroup\AddSystemSettingsGroup as AddSystemSettingsGroupRequests;
use App\Http\Requests\SystemSettingsGroup\UpdateSystemSettingsGroup as UpdateSystemSettingsGroupRequests;
// 系统设置组
class SystemSettingsGroupController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $systemSettingsGroupList = SystemSettingsGroupModel::orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $systemSettingsGroupList['total'];
        $returnData['current_page']     = $systemSettingsGroupList['current_page'];
        $returnData['data']             = $systemSettingsGroupList['data'];
        return success($returnData);
    }
    // 获取所有
    public function all()
    {
        $systemSettingsGroupAll = SystemSettingsGroupModel::orderBy('id', 'desc')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $systemSettingsGroupAll->count();
        $returnData['data']             = $systemSettingsGroupAll->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddSystemSettingsGroupRequests)->verification($request);
        $systemSettingsGroupModel = new SystemSettingsGroupModel;
        $systemSettingsGroupModel->name = $request->input('name');
        $systemSettingsGroupModel->desc = $request->input('desc');
        $addSystemSettingsGroup = $systemSettingsGroupModel->save();
        if(!$addSystemSettingsGroup){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateSystemSettingsGroupRequests)->verification();
        $systemSettingsGroupInfo = SystemSettingsGroupModel::where('id', $id)->firstOrFail();
        $systemSettingsGroupInfo->name = $request->input('name');
        $systemSettingsGroupInfo->desc = $request->input('desc');
        $updateSystemSettingsGroup = $systemSettingsGroupInfo->save();
        if(!$updateSystemSettingsGroup){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteSystemSettingsGroupStatus = SystemSettingsGroupModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteSystemSettingsGroupStatus){
            return errors("系统设置组删除失败");
        }
        return success(['msg'=>"系统设置组删除成功"]);
    }
}
