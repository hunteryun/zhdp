<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\IdNotFound;
// 作物分类
class CropClass extends Model
{
    // 指定表名
    // laravel自动会+s
    protected $table = 'crop_class';
    // 关联分类下的分类
    public function crop_class_child()
    {
         return $this->hasMany(CropClass::class, 'pid', 'id');
    }
    // 关联作物所属分类
    public function crop_class_parent()
    {
         return $this->belongsTo(CropClass::class, 'pid', 'id');
    }
    // 获取分页
    public function getPaginate($request){
        return $this->paginate($request->input('limit'))->toArray();
    }
    // 获取所有
    public function getAll($request){
        return $this->all();
    }
    // 获取单个
    public function getFind($id){
        try{
            return $this->findOrFail($id);
        }catch(\Exception $exception){
            throw new IdNotFound('作物分类Id未找到');
        }
    }
    // 新增作物分类
    public function addCropClass($request){
        $this->name         = $request->input('name');
        $this->user_id      = $request->input('user_id');
        return $this->save();
    }
    // 更新作物分类
    public function updateCropClass($request, $id){
        // 不允许循环赋值，因为有可能存在id,需要更新什么就更新什么
        $cropClassInfo               = $this->getFind($id);
        $cropClassInfo->name         = $request->input('name');
        $cropClassInfo->user_id      = $request->input('user_id');
        return $cropClassInfo->save();
    }
    // 删除作物分类
    public function deleteCropClass($id){
        $cropClassInfo = $this->getFind($id);
        return $cropClassInfo->delete();
    }
}
