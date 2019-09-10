<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章评论
class ArticleComment extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article_comment';
    // 关联查询所属区域
    public function user()
    {
         return $this->belongsTo(User::class);
    }
}
