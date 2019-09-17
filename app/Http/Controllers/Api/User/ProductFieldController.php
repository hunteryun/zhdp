<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\Product as ProductModel;
// 产品字段
class ProductFieldController extends Base
{
    /**
     * 获取所有产品下的所有字段 api/product_field/all
     */
    public function all(Request $request)
    {
        // length是前端关键字,所以重命名为lh
        $productFieldAll = ProductModel::where('id', intval($request->product_id))->firstOrFail()->product_field()->with('field_type')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $productFieldAll->count();
        $returnData['data']             = $productFieldAll->toArray();
        return success(['data'=> $productFieldAll->toArray()]);
    }
}
