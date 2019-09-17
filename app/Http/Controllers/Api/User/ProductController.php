<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\Product as ProductModel;
// 产品
class ProductController extends Base
{
   
    // 获取所有
    public function all()
    {
        $productAll = productModel::all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $productAll->count();
        $returnData['data']             = $productAll->toArray();
        return success($returnData);
    }
}
