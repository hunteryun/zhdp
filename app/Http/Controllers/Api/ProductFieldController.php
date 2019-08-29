<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\ProductField as ProductFieldModel;
use App\Http\Requests\ProductField\AddProductField as AddProductFieldRequests;
use App\Http\Requests\ProductField\UpdateProductField as UpdateProductFieldRequests;
// 产品字段
class ProductFieldController extends Controller
{
    /**
     * 获取产品字段列表 api/product_field?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productFieldList = (new ProductFieldModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $productFieldList['total'];
        $returnData['current_page']     = $productFieldList['current_page'];
        $returnData['data']             = $productFieldList['data'];
        return success($returnData);
    }

    /**
     * 获取所有产品字段 api/product_field/all
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $productFieldAll = (new ProductFieldModel)->getAll($request);
        $returnData['msg']              = "查询成功";
        $returnData['data']             = $productFieldAll;
        $returnData['total']            = $productFieldAll->count();
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建产品字段
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (new AddProductFieldRequests)->verification();
        $addProductField = (new ProductFieldModel)->addProductField($request);
        if(!$addProductField){
            return errors(['msg'=>"产品字段创建失败"]);
        }
        return success(['msg'=>"产品字段创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productFieldInfo = (new ProductFieldModel)->getFind($id);
        return success(['msg' => '产品字段查询成功','data' => $productFieldInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        (new UpdateProductFieldRequests)->verification();
        $updateProductFieldStatus = (new ProductFieldModel)->updateProductField($request, $id);
        if(!$updateProductFieldStatus){
            return errors("产品字段更新失败");
        }
        return success(['msg'=>"产品字段更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProductFieldStatus = (new ProductFieldModel())->deleteProductField($id);
        if(!$deleteProductFieldStatus){
            return errors("产品字段删除失败");
        }
        return success(['msg'=>"产品字段删除成功"]);
    }
}
