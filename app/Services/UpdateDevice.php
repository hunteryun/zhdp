<?php
namespace App\Services;
use App\Model\User as UserModel;
use App\Model\Device as DeviceModel;
use App\Model\DeviceFieldLog as DeviceFieldLogModel;
use App\Model\DeviceEvent as DeviceEventModel;
use App\Model\DeviceEventLog as DeviceEventLogModel;
use DB;
class UpdateDevice
{
    function __construct()
    {
        
    }
    // 记录设备日志
    function addLog($model, $user_id){
        $DeviceFieldLogModel = new DeviceFieldLogModel;
        $DeviceFieldLogModel->user_id = $user_id;
        $DeviceFieldLogModel->device_id = $model->device_id;
        $DeviceFieldLogModel->name = $model->name;
        $DeviceFieldLogModel->field = $model->field;
        $DeviceFieldLogModel->field_type_id = $model->field_type_id;
        $DeviceFieldLogModel->value = $model->value;
        $DeviceFieldLogModel->field_type_length = $model->field_type_length;
        $DeviceFieldLogModel->common_field = $model->common_field;
        $DeviceFieldLogModel->common_field_sort = $model->common_field_sort;
        $DeviceFieldLogModel->desc = $model->desc;
        $DeviceFieldLogModel->sort = $model->sort;
        $DeviceFieldLogModel->save();
    }
    // 记录设备事件日志
    function addDeviceEvent($deviceEventModel, $value){
        $deviceEventLog = new DeviceEventLogModel;
        $deviceEventLog->log_value               = $value;
        $deviceEventLog->user_id                  = $deviceEventModel->user_id;
        $deviceEventLog->name                  = $deviceEventModel->name;
        $deviceEventLog->type                  = $deviceEventModel->type;
        $deviceEventLog->value                 = $deviceEventModel->value;
        $deviceEventLog->desc                  = $deviceEventModel->desc;
        $deviceEventLog->device_region_id             = $deviceEventModel->device_region_id;
        $deviceEventLog->device_room_id             = $deviceEventModel->device_room_id;
        $deviceEventLog->device_id             = $deviceEventModel->device_id;
        $deviceEventLog->device_field_id       = $deviceEventModel->device_field_id;
        $deviceEventLog->associated_device_id  = $deviceEventModel->associated_device_id;
        $deviceEventLog->associated_device_field_id  = $deviceEventModel->associated_device_field_id;
        $deviceEventLog->operation_type        = $deviceEventModel->operation_type;
        $deviceEventLog->save();
    }   
    // 验证设备事件
    function verifyDeviceEvents($deviceFieldModel, $deviceEventModel, $user_id){
        // 获取响应字段
        $responseField = DeviceModel::where('user_id', $user_id)->where('id', $deviceEventModel->associated_device_id)->firstOrFail()->device_field()->where('id', $deviceEventModel->associated_device_field_id)->firstOrFail();
        // 如果响应设备字段已经和设置的阈值相等则不再更新及写入日志
        if($responseField->value != $deviceEventModel->operation_type){
            $responseField->value = $deviceEventModel->operation_type;
            $eventStatus = $responseField->save();
            if($eventStatus){
                // 写入设备日志事件
                $this->addDeviceEvent($deviceEventModel, $deviceFieldModel->value);
                // 写入系统消息
                $title = $deviceEventModel->type == 0? "低于阈值" :  ($deviceEventModel->type == 1 ? "等于阈值" : "高于阈值");
                $content = "事件名称：".$deviceEventModel->name."发生了字段: ".$deviceEventModel->field.$title."事件，请及时检查";
                send_system_msg($user_id, '2', $title, $content);
            }
        }
    }
    // 设备事件
    function deviceEvent($model, $user_id){
        // 事件模型【获取到该设备字段的所有事件】
        $deviceEventModel = DeviceEventModel::where('user_id', $user_id)->where('device_id', $model->device_id)->where('device_field_id', $model->id)->get();
        // 循环判断符合哪一个事件
        foreach($deviceEventModel as $row){
            // 根据类型去执行事件
            switch($row->type){
                // 低于
                case 0:
                    if($model->value < $row->value){
                        $this->verifyDeviceEvents($model, $row, $user_id);
                    }
                    break;
                // 等于
                case 1:
                    if($model->value == $row->value){
                        $this->verifyDeviceEvents($model, $row, $user_id);
                    }
                    break;
                // 高于
                case 2:
                    if($model->value > $row->value){
                        $this->verifyDeviceEvents($model, $row, $user_id);
                    }
                    break;
            }
        }
        
    }
    // 处理bool
    function boolFun($updateValue, $model, $user_id){
        $saveStatus     = false;
        $updateValue    = intval($updateValue);
        if($updateValue == 0 || $updateValue == 1){
            $model->value = $updateValue;
            $saveStatus = $model->save();
            if($saveStatus){
                $this->addLog($model, $user_id);
                $this->deviceEvent($model, $user_id);
            }
        }
        return $saveStatus;
    }
    // 处理整数类型
    function integerFun($updateValue, $model, $user_id){
        $saveStatus     = false;
        $updateValue    = intval($updateValue);
        if(strlen($updateValue) <= $model->field_type_length){
            $model->value = $updateValue;
            $saveStatus = $model->save();
            if($saveStatus){
                $this->addLog($model, $user_id);
                $this->deviceEvent($model, $user_id);
            }
        }
        return $saveStatus;
    }
    // 处理浮点类型
    function floatFun($updateValue, $model, $user_id){
        $saveStatus     = false;
        $updateValue    = floatval($updateValue);
        if(strlen($updateValue) <= $model->field_type_length){
            $model->value = $updateValue;
            $saveStatus = $model->save();
            if($saveStatus){
                $this->addLog($model, $user_id);
                $this->deviceEvent($model, $user_id);
            }
        }
        return $saveStatus;
    }
    // 按照token更新设备字段
    public function updateDeviceField($request, $user_token, $device_token){
        $updateData = $request->input('data');
        // 检测数据格式
        if(empty($updateData) || !is_array($updateData)){
            return errors(['msg'=>'请指定要更新的数据']);
        }
        foreach($updateData as $row){
            if(!is_array($row)){
                return errors(['msg'=>'数据格式不正确0']);
            }
            if(!array_key_exists('field', $row)){
                return errors(['msg'=>'数据格式不正确1']);
            }else if(empty($row['field'])){
                return errors(['msg'=>'数据格式不正确11']);
            }
            if(!array_key_exists('value', $row)){
                return errors(['msg'=>'数据格式不正确2']);
            }else if(empty($row['value'])){
                return errors(['msg'=>'数据格式不正确22']);
            }
        }
        

        $user_id = UserModel::where('token', $user_token)->firstOrFail(['id'])->id;

        $deviceFieldList = UserModel::where('token', $user_token)->firstOrFail()->device()->where('token', $device_token)->firstOrFail()->device_field()->with('field_type')->get();
        // $deviceFieldList = UserModel::where('token', $user_token)->firstOrFail()->device()->where('token', $device_token)->firstOrFail()->device_field()->where('updated_at', '<=', date('Y-m-d H:i:s',( time() - 60)) )->with('field_type')->get();
        
        if($deviceFieldList->isEmpty()){
            return errors(['msg'=>'请检查该设备下是否存在字段或更新过快']);
        }

        $saveStatus = [];
        DB::beginTransaction();

        foreach($deviceFieldList as $model){
            foreach($updateData as $row){
                if($row['field'] == $model->field){
                    $field_type     = $model->field_type;
                    $updateValue    = $row['value'];
                    switch($field_type['name']){
                        case 'bool':
                            // 如果是bool 0为关，1为开
                            $saveStatus[] = $this->boolFun($updateValue, $model, $user_id);
                            break;
                        case 'integer':
                            // 数值类型
                            $saveStatus[] = $this->integerFun($updateValue, $model, $user_id);
                            break;
                        case 'float':
                            // 浮点类型
                            $saveStatus[] = $this->floatFun($updateValue, $model, $user_id);
                            break;
                    }
                }
            }
        }

        if(count(array_unique($saveStatus)) < 2 && count(array_unique($saveStatus)) == 1 && $saveStatus['0'] != false ){
            DB::commit();
            return success(['msg'=>'更新成功']);
        }else{
            DB::rollBack();
            return errors(['msg'=>'更新失败']);
        }
    }
}