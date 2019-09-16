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
/**
 * ----
 * 给指定用户发送系统消息
 * ----
 * @param mixed $user_id 用户id
 * @param mixed $type 消息类型 (0 天气预警 1 病虫害预警 2 设备预警 3 文章被回复)
 * @param mixed $title 消息标题
 * @param mixed $content 消息内容
 * @return bool
 */
function send_system_msg($user_id, $type, $title, $content){
    $SystemMsgMode = new App\Model\SystemMsg;
    $SystemMsgMode->user_id = $user_id;
    $SystemMsgMode->type    = $type;
    $SystemMsgMode->title   = $title;
    $SystemMsgMode->content = $content;
    return $SystemMsgMode->save();
}
/**
 * ----
 * 根据字段获取系统设置值
 * ----
 * @param mixed $field 字段标识
 * @return string/array
 */
function get_system_config($field = ""){
    $systemSettingsGroupFieldInfo = App\Model\SystemSettingsGroupField::where('field', $field)->first(['type', 'option', 'value']);
    if(empty($systemSettingsGroupFieldInfo)){
        return "";
    }
    switch($systemSettingsGroupFieldInfo->type){
        // 普通文本
        case 0:
        // 文本域
        case 1:
        // 单选[返回选择的key]
        case 2:
            $returnConfigValue = $systemSettingsGroupFieldInfo->value;
            break;
        // 多选[返回选择的key]
        case 3:
            $returnConfigValue = explode(',', $systemSettingsGroupFieldInfo->value);
            break;
    }
    return $returnConfigValue;
}
/**
 * ----
 * 根据设置组获取系统设置值
 * ----
 * @param mixed $group 组标识
 * @return string/array
 */
function get_system_group_config($group = ""){
    // $systemSettingsGroupFieldInfo = App\Model\SystemSettingsGroup::where('field', $field)->first(['type', 'option', 'value']);
    // if(empty($systemSettingsGroupFieldInfo)){
    //     return "";
    // }
    // switch($systemSettingsGroupFieldInfo->type){
    //     // 普通文本
    //     case 0:
    //     // 文本域
    //     case 1:
    //     // 单选[返回选择的key]
    //     case 2:
    //         $returnConfigValue = $systemSettingsGroupFieldInfo->value;
    //         break;
    //     // 多选[返回选择的key]
    //     case 3:
    //         $returnConfigValue = explode(',', $systemSettingsGroupFieldInfo->value);
    //         break;
    // }
    // return $returnConfigValue;
}

