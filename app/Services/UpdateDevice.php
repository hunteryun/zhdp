<?php
namespace App\Services;
use App\Model\User as UserModel;
use App\Model\DeviceFieldLog as DeviceFieldLogModel;
use DB;
class UpdateDevice
{
    function __construct()
    {
        $this->deviceFieldLogModel = new DeviceFieldLogModel;
    }
    // 记录日志
    function addLog($model, $user_id){
        $this->deviceFieldLogModel->user_id = $user_id;
        $this->deviceFieldLogModel->device_id = $model->device_id;
        $this->deviceFieldLogModel->name = $model->name;
        $this->deviceFieldLogModel->field = $model->field;
        $this->deviceFieldLogModel->field_type_id = $model->field_type_id;
        $this->deviceFieldLogModel->value = $model->value;
        $this->deviceFieldLogModel->field_type_length = $model->field_type_length;
        $this->deviceFieldLogModel->common_field = $model->common_field;
        $this->deviceFieldLogModel->common_field_sort = $model->common_field_sort;
        $this->deviceFieldLogModel->desc = $model->desc;
        $this->deviceFieldLogModel->sort = $model->sort;
        $this->deviceFieldLogModel->save();
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
            }
        }
        return $saveStatus;
    }
    // 处理整数类型
    function integerFun($updateValue, $model, $user_id){
        $saveStatus     = false;
        $updateValue    = intval($updateValue);
        if(strlen($updateValue) > $model->field_type_length){
            $model->value = $updateValue;
            $saveStatus = $model->save();
            if($saveStatus){
                $this->addLog($model, $user_id);
            }
        }
        return $saveStatus;
    }
    // 处理浮点类型
    function floatFun($updateValue, $model, $user_id){
        $saveStatus     = false;
        $updateValue    = floatval($updateValue);
        if(strlen($updateValue) > $model->field_type_length){
            $model->value = $updateValue;
            $saveStatus = $model->save();
            if($saveStatus){
                $this->addLog($model, $user_id);
            }
        }
        return $saveStatus;
    }
    // 按照token更新设备字段
    public function updateDeviceField($request, $user_token, $device_token){
        $updateData = $request->input('data');

        if(empty($updateData)){
            return errors(['msg'=>'请指定要更新的数据']);
        }

        $user_id = UserModel::where('token', $user_token)->firstOrFail(['id'])->id;

        $deviceFieldList = UserModel::where('token', $user_token)->firstOrFail()->device()->where('token', $device_token)->firstOrFail()->device_field()->where('updated_at', '<', date('Y-m-d H:i:s',( time() - 60)) )->with('field_type')->get();
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
       
        if(count(array_unique($saveStatus)) < 2 && $saveStatus['0'] != false ){
            DB::commit();
            return success(['msg'=>'更新成功']);
        }else{
            DB::rollBack();
            return errors(['msg'=>'更新失败']);
        }
    }
}