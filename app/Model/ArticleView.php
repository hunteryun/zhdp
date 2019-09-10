<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章浏览记录
class ArticleView extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article_view';
}
