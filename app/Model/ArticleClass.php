<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章分类
class ArticleClass extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article_class';
    // 设置默认值 sort 字段
    public function setSortAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['sort'] = 0;
        }else{
            $this->attributes['sort'] = $value;
        }
    }
    // 设置默认值 desc字段
    public function setDescAttribute($value)
    {
        if(is_null($value)){
            $this->attributes['desc'] = '';
        }else{
            $this->attributes['desc'] = $value;
        }
    }
}
