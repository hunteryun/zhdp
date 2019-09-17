<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\Admin as AdminModel;
use App\Http\Requests\Admin\AddAdmin as AddAdminRequests;
use App\Http\Requests\Admin\UpdateAdmin as UpdateAdminRequests;
// 管理员
class AdminController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $adminList = AdminModel::orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $adminList['total'];
        $returnData['current_page']     = $adminList['current_page'];
        $returnData['data']             = $adminList['data'];
        return success($returnData);
    }
    // 获取指定id
    public function show($id)
    {
        $adminInfo = AdminModel::where('id', $id)->firstOrFail();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $adminInfo->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddAdminRequests)->verification($request);
        $adminModel = new AdminModel;
        $adminModel->name = $request->input('name');
        $adminModel->password = $request->input('password');
        $addAdmin = $adminModel->save();
        if(!$addAdmin){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateAdminRequests)->verification();
        $adminInfo = AdminModel::where('id', $id)->firstOrFail();
        $adminInfo->name = $request->input('name');
        // 没有密码则不更新
        if ($request->filled('password')) {
            $adminInfo->password = $request->input('password');
        }
        $updateAdmin = $adminInfo->save();
        if(!$updateAdmin){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteAdminStatus = AdminModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteAdminStatus){
            return errors("管理员删除失败");
        }
        return success(['msg'=>"管理员删除成功"]);
    }
    // 获取自己
    public function get_my(){
        $userInfo = AdminModel::where('token', $this->admin_token())->firstOrFail(['id','name']);
        return success(['data'=>$userInfo]);
    }
    // 更新自己
    public function update_my(Request $request, $id){
        (new UpdateAdminRequests)->verification();
        $userInfo = AdminModel::where('token', $this->admin_token())->firstOrFail();
        $userInfo->name = $request->input('name');
        // 没有密码则不更新
        if ($request->filled('password')) {
            $userInfo->password = $request->input('password');
        }
        $updateUser = $userInfo->save();
        if(!$updateUser){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
}
