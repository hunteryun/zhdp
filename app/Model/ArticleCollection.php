<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章收藏
class ArticleCollection extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article_collection';
}
