<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\User as UserModel;
use App\Model\ArticleView as ArticleViewModel;
use App\Http\Requests\ArticleView\AddArticleView as AddArticleViewRequests;
use App\Http\Requests\ArticleView\UpdateArticleView as UpdateArticleViewRequests;
// 文章浏览记录
class ArticleViewController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit      = $request->input('limit');
        $articleViewList = UserModel::where('token', $this->user_token())->firstOrFail()->article_view()->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $articleViewList['total'];
        $returnData['current_page']     = $articleViewList['current_page'];
        $returnData['data']             = $articleViewList['data'];
        return success($returnData);
    }
    // 新增
     public function store(Request $request)
    {
        (new AddArticleViewRequests)->verification();
        $user_id = UserModel::where('token', $this->user_token())->firstOrFail(['id'])->id;
        $ArticleViewModel = new ArticleViewModel;
        $ArticleViewModel->user_id           = $user_id;
        $ArticleViewModel->article_id        = $request->input('article_id');
        $addArticleView = $ArticleViewModel->save();
        if(!$addArticleView){
            return errors(['msg'=>"文章浏览记录创建失败"]);
        }
        return success(['msg'=>"文章浏览记录创建成功"]);
    }      
    // 更新
    public function update(Request $request, $id){
        (new UpdateArticleViewRequests)->verification();
        $ArticleViewInfo = UserModel::where('token', $this->user_token())->firstOrFail()->article_view()->where('id', $id)->firstOrFail();
        $ArticleViewInfo->article_id        = $request->input('article_id');
        $updateArticleView                  = $ArticleViewInfo->save();
        if(!$updateArticleView){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deletearticleViewStatus = UserModel::where('token', $this->user_token())->firstOrFail()->article_view()->where('id', $id)->firstOrFail()->delete();
        if(!$deletearticleViewStatus){
            return errors("文章浏览记录删除失败");
        }
        return success(['msg'=>"文章浏览记录删除成功"]);
    }
    // 获取自己的浏览
    public function my(Request $request)
    {
        $limit  = $request->input('limit');
        $deviceRegionList = UserModel::where('token', $this->user_token())->firstOrFail()->article_view()->whereHas('article', function($query){
            $request = request();
            $article_class_id  = $request->article_class_id;
            if(!empty($article_class_id)){
                $query->where('article_class_id', intval($article_class_id));
            }
            // 状态
            $status = $request->status;
            if(!empty($status)){
                $query->where('status', intval($status));
            }
            // 作物
            $crop_class_id = $request->crop_class_id;
            if(!empty($crop_class_id)){
                $query->where('crop_class_id', intval($crop_class_id));
            }
            // 标题
            $title = $request->title;
            if(!empty($title)){
                $query->where('title', 'like', '%'.$title.'%');
            }
        })->with('article', 'article.user', 'article.article_class', 'article.crop_class')->orderBy('updated_at','desc')->paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $deviceRegionList['total'];
        $returnData['current_page']     = $deviceRegionList['current_page'];
        $returnData['data']             = $deviceRegionList['data'];
        return success($returnData);
    }
}
