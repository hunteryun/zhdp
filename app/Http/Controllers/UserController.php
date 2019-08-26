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
        return UserModel::paginate($limit);
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
        return $this->success(['msg'=>"用户创建成功"]);
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
            return $this->errors(['msg'=>"用户不存在"]);
        }
        return $this->success(['msg' => '用户查询成功','data' => $userInfo]);
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
            return $this->errors(['msg'=>"用户不存在"]);
        }
        $updateUserStatus = $userModel->updateUser($userInfo, $request->all());
        if(!$updateUserStatus){
            throw (new SystemExceptions("服务器内部错误，请及时联系管理员"));
        }
        return $this->success(['msg'=>"用户更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return $user;
    }
}
