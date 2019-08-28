<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FieldType as FieldTypeModel;
use App\Http\Requests\FieldType\AddFieldType as AddFieldTypeRequests;
use App\Http\Requests\FieldType\UpdateFieldType as UpdateFieldTypeRequests;
// 字段类型
class FieldTypeController extends Controller
{
    /**
     * 获取字段类型列表 api/field_type?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fieldTypeList = (new FieldTypeModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $fieldTypeList['total'];
        $returnData['current_page']     = $fieldTypeList['current_page'];
        $returnData['data']             = $fieldTypeList['data'];
        return success($returnData);
        // return 
    }

    /**
     * 获取所有字段类型 api/field_type/all
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $fieldTypeAll                   = (new FieldTypeModel)->getAll($request);
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $fieldTypeAll;
        $returnData['total']            = $fieldTypeAll->count();
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建字段类型
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 手动进行验证，不使用框架自动验证
        (new AddFieldTypeRequests)->verification($request);
        $addFieldType = (new FieldTypeModel)->addFieldType($request);
        if(!$addFieldType){
            return errors(['msg'=>"字段类型创建失败"]);
        }
        return success(['msg'=>"字段类型创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $fieldTypeInfo = (new FieldTypeModel)->getFind($id);
        if(!$fieldTypeInfo){
            return errors(['msg'=>"字段类型不存在"]);
        }
        return success(['msg' => '字段类型查询成功','data' => $fieldTypeInfo]);
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
        (new UpdateFieldTypeRequests)->verification();
        $updateFieldTypeStatus = (new FieldTypeModel)->updateFieldType($request, $id);
        if(!$updateFieldTypeStatus){
            return errors("字段类型更新失败");
        }
        return success(['msg'=>"字段类型更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteFieldTypeStatus = (new FieldTypeModel())->deleteFieldType($id);
        if(!$deleteFieldTypeStatus){
            return errors("字段类型删除失败");
        }
        return success(['msg'=>"字段类型删除成功"]);
    }
}
