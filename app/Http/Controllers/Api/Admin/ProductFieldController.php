<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Base;
use Illuminate\Http\Request;
use App\Model\Product as ProductModel;
use App\Model\ProductField as ProductFieldModel;
use App\Http\Requests\ProductField\AddProductField as AddProductFieldRequests;
use App\Http\Requests\ProductField\UpdateProductField as UpdateProductFieldRequests;
// 产品字段
class ProductFieldController extends Base
{
    /**
     * 获取所有产品下的所有字段 api/product_field/all
     */
    public function all(Request $request)
    {
        // length是前端关键字,所以重命名为lh
        $productFieldAll = ProductModel::where('id', intval($request->product_id))->firstOrFail()->product_field()->with('field_type')->get();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $productFieldAll->count();
        $returnData['data']             = $productFieldAll->toArray();
        return success(['data'=> $productFieldAll->toArray()]);
    }
    // 新增
    public function store(Request $request){
        (new AddProductFieldRequests)->verification();
        $productFieldModel = new ProductFieldModel;
        $productFieldModel->product_id    = $request->input('product_id');
        $productFieldModel->name          = $request->input('name');
        $productFieldModel->field         = $request->input('field');
        $productFieldModel->field_type_id = $request->input('field_type_id');
        $productFieldModel->field_type_length        = $request->input('field_type_length');
        $productFieldModel->default       = $request->input('default');
        $productFieldModel->common_field  = $request->input('common_field');
        $productFieldModel->common_field_sort  = $request->input('common_field_sort');
        $productFieldModel->desc          = $request->input('desc');
        $productFieldModel->sort          = $request->input('sort');
        $addProductFieldStatus = $productFieldModel->save();
        if(!$addProductFieldStatus){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateProductFieldRequests)->verification();
        $productInfo = ProductFieldModel::where('id', $id)->firstOrFail();
        $productInfo->name          = $request->input('name');
        $productInfo->field         = $request->input('field');
        $productInfo->field_type_id = $request->input('field_type_id');
        $productInfo->field_type_length        = $request->input('field_type_length');
        $productInfo->default       = $request->input('default');
        $productInfo->common_field  = $request->input('common_field');
        $productInfo->common_field_sort  = $request->input('common_field_sort');
        $productInfo->desc          = $request->input('desc');
        $productInfo->sort          = $request->input('sort');
        $updateproduct = $productInfo->save();
        if(!$updateproduct){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteproductStatus = ProductFieldModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteproductStatus){
            return errors("产品字段删除失败");
        }
        return success(['msg'=>"产品字段删除成功"]);
    }
}
