<?php
namespace App\Services;
use App\Model\User as UserModel;
use DB;
class UpdateDevice
{
    // 处理bool
    function boolFun($updateValue, $model){
        $saveStatus     = false;
        $updateValue    = intval($updateValue);
        if($updateValue == 0 || $updateValue == 1){
            $model->value = $updateValue;
            $saveStatus = $model->save();
        }
        return $saveStatus;
    }
    // 按照token更新设备字段
    public function updateDeviceField($request, $user_token, $device_token){
        $updateDataField = $request->input('data.field');
        if(empty($updateDataField)){
            return errors(['msg'=>'请指定要更新的字段']);
        }
        $deviceFieldList = UserModel::where('token', $user_token)->firstOrFail()->device()->where('token', $device_token)->firstOrFail()->device_field()->where('updated_at', '<', date('Y-m-d H:i:s',( time() - 60)) )->with('field_type')->get(['id','field','field_type_id']);
        if($deviceFieldList->isEmpty()){
            return errors(['msg'=>'请检查该设备下是否存在字段或更新过快']);
        }

        $saveStatus = [];
        DB::beginTransaction();

        foreach($deviceFieldList as $key => $value){
            if(array_key_exists($value->field, $updateDataField)){
                $field_type     = $value->field_type;
                $updateValue    = $updateDataField[$value->field];
                switch($field_type['name']){
                    case 'bool':
                        // 如果是bool 0为关，1为开
                        $saveStatus[] = $this->boolFun($updateValue, $value);
                        break;
                }
            }else{
                DB::rollBack();
                return errors(['msg'=>'更新失败']);
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