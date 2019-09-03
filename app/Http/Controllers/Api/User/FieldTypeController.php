<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\FieldType as FieldTypeModel;
use App\Http\Requests\FieldType\AddFieldType as AddFieldTypeRequests;
use App\Http\Requests\FieldType\UpdateFieldType as UpdateFieldTypeRequests;
// 字段类型
class FieldTypeController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $fieldTypeList = FieldTypeModel::paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $fieldTypeList['total'];
        $returnData['current_page']     = $fieldTypeList['current_page'];
        $returnData['data']             = $fieldTypeList['data'];
        return success($returnData);
    }
    // 获取所有
    public function all()
    {
        $fieldTypeAll = FieldTypeModel::all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $fieldTypeAll->count();
        $returnData['data']             = $fieldTypeAll->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddFieldTypeRequests)->verification($request);
        $fieldTypeModel = new FieldTypeModel;
        $fieldTypeModel->name = $request->input('name');
        $fieldTypeModel->length = $request->input('length');
        $fieldTypeModel->default = $request->input('default');
        $fieldTypeModel->desc = $request->input('desc');
        $addFieldType = $fieldTypeModel->save();
        if(!$addFieldType){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateFieldTypeRequests)->verification();
        $fieldTypeInfo = FieldTypeModel::where('id', $id)->firstOrFail();
        $fieldTypeInfo->name = $request->input('name');
        $fieldTypeInfo->length = $request->input('length');
        $fieldTypeInfo->default = $request->input('default');
        $fieldTypeInfo->desc = $request->input('desc');
        $updateFieldType = $fieldTypeInfo->save();
        if(!$updateFieldType){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteFieldTypeStatus = FieldTypeModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteFieldTypeStatus){
            return errors("字段类型删除失败");
        }
        return success(['msg'=>"字段类型删除成功"]);
    }
}
