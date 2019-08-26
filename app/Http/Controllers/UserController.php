<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Http\Requests\User\AddUser as AddUserRequests;
use App\Exceptions\System as SystemExceptions;
use App\Http\Requests\User\UpdateUser as UpdateUserRequests;

class UserController extends Controller
{
    /**
     * 获取用户列表 api/user?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = intval($request->input('limit'));
        $userList = UserModel::paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $userList['total'];
        $returnData['current_page']     = $userList['current_page'];
        $returnData['data']             = $userList['data'];
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建用户
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new AddUserRequests)->verification($request);
        $addUserStatus = (new UserModel)->addUser($request->all());
        if(!$addUserStatus){
            throw (new SystemExceptions("服务器内部错误，请及时联系管理员"));
        }
        return success(['msg'=>"用户创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userInfo = UserModel::find($id);
        if(!$userInfo){
            return errors(['msg'=>"用户不存在"]);
        }
        return success(['msg' => '用户查询成功','data' => $userInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        (new UpdateUserRequests)->verification($request);
        //
        $userModel = new UserModel;
        $userInfo = $userModel->find($id);
        if(!$userInfo){
            return errors(['msg'=>"用户不存在"]);
        }
        $updateUserStatus = $userModel->updateUser($userInfo, $request->all());
        if(!$updateUserStatus){
            throw (new SystemExceptions("服务器内部错误，请及时联系管理员"));
        }
        return success(['msg'=>"用户更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userModel = new UserModel;
        $userInfo = $userModel->find($id);
        if(!$userInfo){
            return errors(['msg'=>"用户不存在"]);
        }
        // 后面可能还会因为删除用户，关联删除他的其他   
        $deleteUserStatus = $userInfo->deleteUser($userInfo);
        if(!$deleteUserStatus){
            throw (new SystemExceptions("服务器内部错误，请及时联系管理员"));
        }
        return success(['msg'=>"用户删除成功"]);
    }
}
