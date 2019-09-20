<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Http\Requests\User\AddUser as AddUserRequests;
use App\Http\Requests\User\UpdateUser as UpdateUserRequests;
// 用户
class UserController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $userList = UserModel::orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $userList['total'];
        $returnData['current_page']     = $userList['current_page'];
        $returnData['data']             = $userList['data'];
        return success($returnData);
    }
    // 获取指定id
    public function show($id)
    {
        $userInfo = UserModel::where('id', $id)->firstOrFail();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $userInfo->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddUserRequests)->verification($request);
        $userModel = new UserModel;
        $userModel->phone = $request->input('phone');
        $userModel->name = $request->input('name');
        $userModel->password = $request->input('password');
        $addUser = $userModel->save();
        if(!$addUser){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateUserRequests)->verification();
        $userInfo = UserModel::where('id', $id)->firstOrFail();
        $userInfo->name = $request->input('name');
        $userInfo->phone = $request->input('phone');
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
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteUserStatus = UserModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteUserStatus){
            return errors("用户删除失败");
        }
        return success(['msg'=>"用户删除成功"]);
    }
}
