<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'user';
    // 关联产品表
    public function product()
    {
         return $this->hasMany(Product::class);
    }
    // 关联设备区域表
    public function device_region()
    {
         return $this->hasMany(DeviceRegion::class);
    }
    // 关联设备房间表
    public function device_room()
    {
         return $this->hasMany(DeviceRoom::class);
    }
    // 关联设备表
    public function device()
    {
         return $this->hasMany(Device::class);
    }
    // 关联设备字段日志表
    public function device_field_log()
    {
         return $this->hasMany(DeviceFieldLog::class);
    }
    // 关联文章表
    public function article()
    {
         return $this->hasMany(Article::class);
    }
    // 关联文章浏览记录表
    public function article_view()
    {
         return $this->hasMany(ArticleView::class);
    }
    // 文章收藏表
    public function article_collection()
    {
         return $this->hasMany(ArticleCollection::class);
    }
    // 文章评论表
    public function article_comment()
    {
         return $this->hasMany(ArticleComment::class);
    }
     // 设备事件表
     public function device_event()
     {
          return $this->hasMany(DeviceEvent::class);
     }
     // 设备事件日志表
     public function device_event_log()
     {
          return $this->hasMany(DeviceEventLog::class);
     }
     // 预警日志
     public function pest_warning_log()
     {
          return $this->hasMany(PestWarningLog::class);
     }
     // 登录通知
     public function login_notice_log()
     {
          return $this->hasMany(LoginNoticeLog::class);
     }
     // 系统消息
     public function system_msg()
     {
          return $this->hasMany(SystemMsg::class);
     }
}
