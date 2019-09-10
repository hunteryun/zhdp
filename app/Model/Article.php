<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
// 文章
class Article extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'article';
    // 关联查询所属用户
    public function user()
    {
         return $this->belongsTo(User::class);
    }
    // 关联查询房间下的设备
    // public function device()
    // {
    //      return $this->hasMany(Device::class);
    // }
}
