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
    // 获取所有子分类
    public function all_child(Request $request)
    {
        $cropClassAll = CropClassModel::where('id', '<>', 0)->where('pid', '<>', 0)->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $cropClassAll->count();
        $returnData['data']             = $cropClassAll->toArray();
        return success($returnData);
    }
}
