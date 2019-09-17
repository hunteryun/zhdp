<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\ArticleClass as ArticleClassModel;
// 文章分类
class ArticleClassController extends Base
{
    // 获取所有
    public function all(Request $request)
    {
        $articleClassAll = ArticleClassModel::all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $articleClassAll->count();
        $returnData['data']             = $articleClassAll->toArray();
        return success($returnData);
    }
}
