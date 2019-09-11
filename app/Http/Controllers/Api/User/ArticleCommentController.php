<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\ArticleComment as ArticleCommentModel;
use App\Http\Requests\ArticleComment\AddArticleComment as AddArticleCommentRequests;
use App\Http\Requests\ArticleComment\UpdateArticleComment as UpdateArticleCommentRequests;
// 文章评论
class ArticleCommentController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit      = $request->input('limit');
        $article_id = $request->input('article_id');
        $deviceRegionList = ArticleCommentModel::where('article_id', intval($article_id))->with('user')->orderBy('id', 'desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
    // 新增
     public function store(Request $request)
    {
        (new AddArticleCommentRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $articleCommentModel = new ArticleCommentModel;
        $articleCommentModel->user_id           = $user_id;
        $articleCommentModel->article_id        = $request->input('article_id');
        $articleCommentModel->content           = $request->input('content');
        $addArticleComment = $articleCommentModel->save();
        if(!$addArticleComment){
            return errors(['msg'=>"文章评论创建失败"]);
        }
        return success(['msg'=>"文章评论创建成功"]);
    }      
    // 获取指定id 
      public function show($id)
    {
        $articleCommentInfo = ArticleCommentModel::where('id', $id)->firstOrFail();
        return success(['msg' => '文章评论查询成功','data' => $articleCommentInfo]);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateArticleCommentRequests)->verification();
        $articleCommentInfo = UserModel::where('token', $this->user_token())->firstOrFail()->article_comment()->where('id', $id)->firstOrFail();
        $articleCommentInfo->article_id     = $request->input('article_id');
        $articleCommentInfo->content        = $request->input('content');
        $updateArticleComment = $articleCommentInfo->save();
        if(!$updateArticleComment){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article_comment()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("文章评论删除失败");
        }
        return success(['msg'=>"文章评论删除成功"]);
    }
}
