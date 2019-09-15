<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\LoginNotice as LoginNoticeModel;
use App\Model\LoginNoticeLog as LoginNoticeLogModel;
use App\Model\User as UserModel;
use App\Http\Requests\LoginNotice\AddLoginNotice as AddLoginNoticeRequests;
use App\Http\Requests\LoginNotice\UpdateLoginNotice as UpdateLoginNoticeRequests;
// 登陆通知
class LoginNoticeController extends Base
{
    // 获取列表(即时通知与每次通知)
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $loginNoticeList = LoginNoticeModel::orderBy("id", "desc")->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeList['total'];
        $returnData['current_page']     = $loginNoticeList['current_page'];
        $returnData['data']             = $loginNoticeList['data'];
        return success($returnData);
    }
    // 获取即时通知列表
    public function every_day(Request $request)
    {
        $limit = $request->input('limit');
        $loginNoticeList = LoginNoticeModel::where('type', '0')->orderBy("id", "desc")->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeList['total'];
        $returnData['current_page']     = $loginNoticeList['current_page'];
        $returnData['data']             = $loginNoticeList['data'];
        return success($returnData);
    }
    // 获取所有每次登录通知
    public function every_day_all(Request $request)
    {
        $loginNoticeAll = LoginNoticeModel::orderBy("id", "desc")->where('type', 0)->all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $loginNoticeAll->count();
        $returnData['data']             = $loginNoticeAll->toArray();
        return success($returnData);
    }
    // 获取指定id
    public function show(Request $request, $id)
    {
        $loginNoticeInfo = LoginNoticeModel::wher("id", $id)->firstOrFail();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $loginNoticeInfo->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddLoginNoticeRequests)->verification($request);
        $loginNoticeModel = new LoginNoticeModel;
        $loginNoticeModel->title = $request->input('title');
        $loginNoticeModel->content = $request->input('content');
        $loginNoticeModel->type = $request->input('type');
        $addLoginNotice = $loginNoticeModel->save();
        // 写入日志
        if($loginNoticeModel->type == 1){
            $login_notice_id = $loginNoticeModel->id;
            $date_time = date("Y-m-d H:i:s", time()); 
            UserModel::chunk(100, function ($users) use ($login_notice_id, $date_time){
                $logs = [];
                foreach ($users as $user) {
                    $log = [];
                    $log['login_notice_id'] = $login_notice_id;
                    $log['user_id'] = $user->id;
                    $log['status'] = '0';
                    $log['updated_at'] = $date_time;
                    $log['created_at'] = $date_time;
                    $logs[] = $log;
                }
                LoginNoticeLogModel::insert($logs);
            });
        }
        if(!$addLoginNotice){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateLoginNoticeRequests)->verification();
        $loginNoticeInfo = LoginNoticeModel::where('id', $id)->firstOrFail();
        $loginNoticeInfo->title = $request->input('title');
        $loginNoticeInfo->content = $request->input('content');
        // 更新的时候不可以设置类型(可能会出现冲突)
        // $loginNoticeInfo->type = $request->input('type');
        $updateLoginNotice = $loginNoticeInfo->save();
        if(!$updateLoginNotice){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteLoginNoticeStatus = LoginNoticeModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteLoginNoticeStatus){
            return errors("登陆通知删除失败");
        }
        return success(['msg'=>"登陆通知删除成功"]);
    }
}
