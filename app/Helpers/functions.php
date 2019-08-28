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
function errors($arr = [], $httpCode = 404)
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
// 生成唯一token
function getOnlyToken_60()
{
    // $stime=microtime(true); 
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $yCount = count($yCode);
    $token =
    $yCode[date('Y') % $yCount] . 
    $yCode[date('Ymd') % $yCount] . 
    $yCode[date('His') % $yCount] . 
    $yCode[date('i') % $yCount] . 
    $yCode[date('s') % $yCount] . 
    strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . 
    sprintf('%02d', rand(0, 99)) .
    strtoupper(sha1(microtime(true).$yCode[date('s') % $yCount]));
    // $etime=microtime(true);
    // dd( '耗时'.(($etime-$stime)* 1000).'秒<br>');
    return $token;
}
