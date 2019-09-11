<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章浏览记录
class ArticleView extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article_view';
    // 关联查询所属文章
    public function article()
    {
         return $this->belongsTo(Article::class);
    }
}
