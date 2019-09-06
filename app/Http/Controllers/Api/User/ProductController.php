<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\User\Base;
use Illuminate\Http\Request;
use App\Model\Product as ProductModel;
use App\Http\Requests\Product\AddProduct as AddProductRequests;
use App\Http\Requests\Product\UpdateProduct as UpdateProductRequests;
// 产品
class ProductController extends Base
{
    // 获取列表
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $productList = productModel::paginate($limit)->toArray();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $productList['total'];
        $returnData['current_page']     = $productList['current_page'];
        $returnData['data']             = $productList['data'];
        return success($returnData);
    }
    // 获取所有
    public function all()
    {
        $productAll = productModel::all();
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['count']            = $productAll->count();
        $returnData['data']             = $productAll->toArray();
        return success($returnData);
    }
    // 新增
    public function store(Request $request){
        (new AddproductRequests)->verification($request);
        $productModel = new productModel;
        $productModel->name = $request->input('name');
        $productModel->desc = $request->input('desc');
        $addproduct = $productModel->save();
        if(!$addproduct){
            return errors(['msg'=>'创建失败']);
        }
        return success(['msg'=>'创建成功']);
    }
    // 更新
    public function update(Request $request, $id){
        (new UpdateproductRequests)->verification();
        $productInfo = productModel::where('id', $id)->firstOrFail();
        $productInfo->name = $request->input('name');
        $productInfo->desc = $request->input('desc');
        $updateproduct = $productInfo->save();
        if(!$updateproduct){
            return errors(['msg'=>'更新失败']);
        }
        return success(['msg'=>'更新成功']);
    }
    // 删除
    public function destroy(Request $request, $id){
        
        $deleteproductStatus = productModel::where('id', $id)->firstOrFail()->delete();
        if(!$deleteproductStatus){
            return errors("产品删除失败");
        }
        return success(['msg'=>"产品删除成功"]);
    }
}
