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
}
