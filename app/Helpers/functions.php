<?php
// 公共函数 https://www.cnblogs.com/richerdyoung/p/10043859.html

// 成功返回
function success($arr = [], $httpCode = 200)
{
    // code 最前面 msg在他后面
    if (!array_key_exists('code', $arr)) {
        $arr['code'] = 0;
    };
    if (!array_key_exists('msg', $arr)) {
        $arr['msg'] = '请求成功';
    };
    // 此处必须要返回，不然会导致页面显示为空...
    return json($arr, $httpCode);
}
// 错误返回
function errors($arr = [], $httpCode = 200)
{
    // code 最前面 msg在他后面
    if (!array_key_exists('code', $arr)) {
        $arr['code'] = 1;
    };
    if (!array_key_exists('msg', $arr)) {
        $arr['msg'] = '请求失败';
    };
    // 此处必须要返回，不然会导致页面显示为空...
    return json($arr, $httpCode);
}
// 返回json
function json($arr = [], $httpCode)
{
    return response()->json($arr, $httpCode);
}

