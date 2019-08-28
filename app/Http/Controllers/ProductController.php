<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Product as ProductModel;
use App\Http\Requests\Product\AddProduct as AddProductRequests;
use App\Http\Requests\Product\UpdateProduct as UpdateProductRequests;
// 产品
class ProductController extends Controller
{
    /**
     * 获取产品列表 api/Product?page=2&limit=2
     * @param $page 页码
     * @param $limit 数量
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productList = (new ProductModel)->getPaginate($request);
        $returnData = [];
        $returnData['msg']              = "查询成功";
        $returnData['total']            = $productList['total'];
        $returnData['current_page']     = $productList['current_page'];
        $returnData['data']             = $productList['data'];
        return success($returnData);
        // return 
    }

    /**
     * Store a newly created resource in storage.
     * --------
     * 创建产品
     * --------
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        (new AddProductRequests)->verification($request);
        $addProductStatus = (new ProductModel)->addProduct($request);
        if(!$addProductStatus){
            return errors(['msg'=>"产品创建失败"]);
        }
        return success(['msg'=>"产品创建成功"]);
    }       

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productInfo = (new ProductModel)->getFind($id);
        if(!$productInfo){
            return errors(['msg'=>"产品不存在"]);
        }
        return success(['msg' => '产品查询成功','data' => $productInfo]);
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
        (new UpdateProductRequests)->verification();
        $updateProductStatus = (new ProductModel)->updateProduct($request, $id);
        if(!$updateProductStatus){
            return errors("产品更新失败");
        }
        return success(['msg'=>"产品更新成功"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProductStatus = (new ProductModel())->deleteProduct($id);
        if(!$deleteProductStatus){
            return errors("产品删除失败");
        }
        return success(['msg'=>"产品删除成功"]);
    }
}
