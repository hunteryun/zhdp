<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\CropClass as CropClassModel;
use App\Http\Requests\CropClass\AddCropClass as AddCropClassRequests;
use App\Http\Requests\CropClass\UpdateCropClass as UpdateCropClassRequests;
// 作物分类
class CropClassController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $cropClassList = CropClassModel::where('id', '<>', 0)->with('crop_class_parent')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropClassList['total'];
        $returnData['current_page']     = $cropClassList['current_page'];
        $returnData['data']             = $cropClassList['data'];
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddCropClassRequests)->verification($request);
        $name = $request->input('name');
        $pid = $request->input('pid');
        $cropClassModel = new CropClassModel;
        $cropClassModel->name = $name;
        $cropClassModel->pid = $pid;
        $addCropClass = $cropClassModel->save();
        if(!$addCropClass){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateCropClassRequests)->verification();
        $name = $request->input('name');
        $cropClassInfo = CropClassModel::where('id', $id)->where('id', '<>', 0)->firstOrFail();
        $cropClassInfo->name = $name;
        $updateCropClass = $cropClassInfo->save();
        if(!$updateCropClass){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteCropClassStatus = CropClassModel::where('id', $id)->where('id', '<>', 0)->firstOrFail()->delete();
        if(!$deleteCropClassStatus){
            return errors("作物分类删除失败");
        }
        return success(['msg'=>"作物分类删除成功"]);
    }
    // 获取所有顶级分类
    public function topAll()
    {
        $cropClassAll = CropClassModel::where('pid', 0)->where('id', '<>', 0)->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropClassAll->count();
        $returnData['data']             = $cropClassAll->toArray();
        return success($returnData);
    }
    // 根据顶级分类的id获取所属作物
    public function topIdAll(Request $request, $id)
    {
        $cropClassAll = CropClassModel::where('id', $id)->where('id', '<>', 0)->firstOrFail()->crop_class_child()->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropClassAll->count();
        $returnData['data']             = $cropClassAll->toArray();
        return success($returnData);
    }
}
