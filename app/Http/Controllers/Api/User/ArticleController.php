<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\Article as ArticleModel;
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
        $article_class_id  = $request->article_class_id;
        if(!empty($article_class_id)){
            $where['article_class_id'] = intval($article_class_id);
        }
        // 状态
        $status = $request->status;
        if(!empty($status)){
            $where['status'] = intval($status);
        }
        // 作物
        $crop_class_id = $request->crop_class_id;
        if(!empty($crop_class_id)){
            $where['crop_class_id'] = intval($crop_class_id);
        }
        $limit  = $request->input('limit');
        $deviceRegionList = ArticleModel::where($where)->orderBy('id','desc')->with('user')->paginate($limit)->toArray();
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
    // 新增
     public function store(Request $request)
    {
        (new AddArticleRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $articleModel = new ArticleModel;
        $articleModel->user_id          = $user_id;
        $articleModel->title            = $request->input('title');
        $articleModel->content          = $request->input('content');
        $articleModel->crop_class_id    = $request->input('crop_class_id');
        $articleModel->article_class_id = $request->input('article_class_id');
        $addArticle = $articleModel->save();
        if(!$addArticle){
            return errors(['msg'=>"文章创建失败"]);
        }
        return success(['msg'=>"文章创建成功"]);
    }      
    // 更新
    public function update(Request $request, $id){
        (new UpdateArticleRequests)->verification();
        $articleInfo = UserModel::where('token', $this->user_token())->firstOrFail()->article()->where('id', $id)->firstOrFail();
        $articleInfo->title             = $request->input('title');
        $articleInfo->content           = $request->input('content');
        $articleInfo->crop_class_id     = $request->input('crop_class_id');
        $articleInfo->article_class_id  = $request->input('article_class_id');
        $updateArticle = $articleInfo->save();
        if(!$updateArticle){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteDeviceRegionStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article()->where('id', $id)->firstOrFail()->delete();
        if(!$deleteDeviceRegionStatus){
            return errors("文章删除失败");
        }
        return success(['msg'=>"文章删除成功"]);
    }
}
