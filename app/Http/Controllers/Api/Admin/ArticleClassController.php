<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\ArticleClass as ArticleClassModel;
use App\Http\Requests\ArticleClass\AddArticleClass as AddArticleClassRequests;
use App\Http\Requests\ArticleClass\UpdateArticleClass as UpdateArticleClassRequests;
// 文章分类
class ArticleClassController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $articleClassList = ArticleClassModel::orderBy('sort', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $articleClassList['total'];
        $returnData['current_page']     = $articleClassList['current_page'];
        $returnData['data']             = $articleClassList['data'];
        return success($returnData);
    }
    // 获取所有
    public function all()
    {
        $articleClassAll = ArticleClassModel::all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $articleClassAll->count();
        $returnData['data']             = $articleClassAll->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddArticleClassRequests)->verification($request);
        $articleClassModel = new ArticleClassModel;
        $articleClassModel->name = $request->input('name');
        $articleClassModel->sort = $request->input('sort');
        $articleClassModel->desc = $request->input('desc');
        $addArticleClass = $articleClassModel->save();
        if(!$addArticleClass){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateArticleClassRequests)->verification();
        $articleClassInfo = ArticleClassModel::where('id', $id)->firstOrFail();
        $articleClassInfo->name = $request->input('name');
        $articleClassInfo->sort = $request->input('sort');
        $articleClassInfo->desc = $request->input('desc');
        $updateArticleClass = $articleClassInfo->save();
        if(!$updateArticleClass){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteArticleClassStatus = ArticleClassModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteArticleClassStatus){
            return errors("文章分类删除失败");
        }
        return success(['msg'=>"文章分类删除成功"]);
    }
}
