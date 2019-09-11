<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\ArticleCollection as ArticleCollectionModel;
use App\Http\Requests\ArticleCollection\AddArticleCollection as AddArticleCollectionRequests;
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
    // 获取指定id是否收藏 
    public function show($article_id)
    {
        $articleExists = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('article_id', $article_id)->exists();
        if($articleExists){
            return success(['msg'=>"文章已收藏"]);
        }
        return errors(['msg'=>"文章未收藏"]);
    }    
    // 新增[如果存在则删除，如果不存在则增加]
     public function store(Request $request)
    {
        (new AddArticleCollectionRequests)->verification();
        $article_id = $request->article_id;
        $articleExists = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('article_id', $article_id)->exists();
        if($articleExists){
            $deleteArticleCollectionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('article_id', $article_id)->firstOrFail()->delete();
            if(!$deleteArticleCollectionStatus){
                return errors(['msg'=>"文章收藏删除失败", 'status' => 0]);
            }
            return success(['msg'=>"文章收藏删除成功", 'status' => 0]);
        }else{
            $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
            $articleCollectionModel = new ArticleCollectionModel;
            $articleCollectionModel->user_id           = $user_id;
            $articleCollectionModel->article_id        = $request->input('article_id');
            $addArticleCollection = $articleCollectionModel->save();
            if(!$addArticleCollection){
                return errors(['msg'=>"文章收藏创建失败", 'status' => 1]);
            }
            return success(['msg'=>"文章收藏创建成功", 'status' => 1]);
        }
    }  
    // 删除
    public function destroy(Request $request, $id){
        $deleteArticleCollectionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article_collection()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteArticleCollectionStatus){
            return errors(['msg'=>"文章收藏删除失败"]);
        }
        return success(['msg'=>"文章收藏删除成功"]);
    }
}
