<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\Article as ArticleModel;
use App\Model\ArticleView as ArticleViewModel;
use App\Http\Requests\Article\AddArticle as AddArticleRequests;
use App\Http\Requests\Article\UpdateArticle as UpdateArticleRequests;
// 文章
class ArticleController extends Base
{
    // 获取文章列表
    // @url api/user/article?article_class_id=1&status=1&crop_class_id=1
    public function index(Request $request)
    {
        $where = [];
        // 分类
        if($request->filled('article_class_id')){
            $where['article_class_id'] = intval($request->article_class_id);
        }
        // 状态
        if($request->filled('status')){
            $where['status'] = intval($request->status);
        }
        // 作物
        if($request->filled('crop_class_id')){
            $where['crop_class_id'] = intval($request->crop_class_id);
        }
        // 标题
        if($request->filled('title')){
            $where[] = ['title', 'like', '%'.$request->title.'%'];
        }
        $limit  = $request->input('limit');
        $deviceRegionList = ArticleModel::where($where)->orderBy('id','desc')->with('user', 'article_class', 'crop_class')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
    // 获取指定id 
    public function show($id)
    {
        $articleInfo = ArticleModel::where('id', $id)->with('user')->firstOrFail();
        return success(['msg' => '文章查询成功','data' => $articleInfo]);
    }
}
