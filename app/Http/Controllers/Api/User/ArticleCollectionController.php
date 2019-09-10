<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\ArticleCollection as ArticleCollectionModel;
use App\Http\Requests\ArticleCollection\AddArticleCollection as AddArticleCollectionRequests;
use App\Http\Requests\ArticleCollection\UpdateArticleCollection as UpdateArticleCollectionRequests;
// 文章收藏
class ArticleCollectionController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit      = $request->input('limit');
        $articleCollectionList = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $articleCollectionList['total'];
        $returnData['current_page']     = $articleCollectionList['current_page'];
        $returnData['data']             = $articleCollectionList['data'];
        return success($returnData);
    }
    // 新增
     public function store(Request $request)
    {
        (new AddArticleCollectionRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $articleCollectionModel = new ArticleCollectionModel;
        $articleCollectionModel->user_id           = $user_id;
        $articleCollectionModel->article_id        = $request->input('article_id');
        $addArticleCollection = $articleCollectionModel->save();
        if(!$addArticleCollection){
            return errors(['msg'=>"文章收藏创建失败"]);
        }
        return success(['msg'=>"文章收藏创建成功"]);
    }      
    // 更新
    public function update(Request $request, $id){
        (new UpdateArticleCollectionRequests)->verification();
        $articleCollectionInfo = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('id', $id)->firstOrFail();
        $articleCollectionInfo->article_id        = $request->input('article_id');
        $updateArticleCollection                  = $articleCollectionInfo->save();
        if(!$updateArticleCollection){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteArticleCollectionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteArticleCollectionStatus){
            return errors("文章收藏删除失败");
        }
        return success(['msg'=>"文章收藏删除成功"]);
    }
}
