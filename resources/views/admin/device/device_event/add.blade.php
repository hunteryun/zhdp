 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
    <div class="layui-container" style="padding:15px">
        <form class="layui-form layui-form-pane" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">事件名称</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="name" lay-verify="required" autocomplete="off" placeholder="设备事件名称">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">事件描述</label>
                <div class="layui-input-inline">
                    <textarea type="text" class="layui-textarea" name="desc" placeholder="设备事件描述"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备区域</label>
                <div class="layui-input-inline">
                    <select id="device_region_id" name="device_region_id" lay-verify="required" lay-filter="device_region_id">
                        <option value="">加载区域中...</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备房间</label>
                <div class="layui-input-inline">
                    <select id="device_room_id" name="device_room_id" lay-verify="required" lay-filter="device_room_id">
                        <option value="">请先选择区域</option>
                    </select>     
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>触发设备</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">设备</label>
                <div class="layui-input-inline">
                    <select id="device_id" name="device_id" lay-verify="required" lay-filter="device_id">
                        <option value="">请选择房间</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备字段</label>
                <div class="layui-input-inline">
                    <select id="device_field_id" name="device_field_id" lay-verify="required" lay-filter="device_field_id">
                        <option value="">请选择设备</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">事件类型</label>
                <div class="layui-input-inline">
                    <select id="type" name="type" lay-verify="required" lay-filter="type">
                        <option value="0">低于指定值</option>
                        <option value="1">等于指定值</option>
                        <option value="2">高于指定值</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">事件阈值</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="value" lay-verify="required" autocomplete="off" placeholder="事件阈值">
                </div>
            </div>
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>响应设备</legend>
            </fieldset>
            <div class="layui-form-item">
                <label class="layui-form-label">设备</label>
                <div class="layui-input-inline">
                    <select id="associated_device_id" name="associated_device_id" lay-verify="required" lay-filter="associated_device_id">
                        <option value="">请选择触发设备</option>
                    </select>     
                </div>
                <div class="layui-form-mid layui-word-aux">设备只能是同房间下，不是自己。并且只能操作继电器</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">设备字段</label>
                <div class="layui-input-inline">
                    <select id="associated_device_field_id" name="associated_device_field_id" lay-verify="required" lay-filter="associated_device_field_id">
                        <option value="">请先选择设备</option>
                    </select>     
                </div>
                <div class="layui-form-mid layui-word-aux">字段为bool的可以操作</div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">操作类型</label>
                <div class="layui-input-inline">
                    <select id="operation_type" name="operation_type" lay-verify="required" lay-filter="operation_type">
                        <option value="0">关闭</option>
                        <option value="1">打开</option>
                    </select>     
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">提交</button>
                    <button type="reset" id="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
     @include('admin.public.include_js')
     <script>
         //缓存区域与房间
         var device_region_list;
         var device_list;
        //  初始化设备区域
        ajaxLoad1 = layer.load(1, {
            shade: [0.8, '#393D49']
        });
         $.ajax({ 
            type: "GET",
            url: '{{url("api/admin/device_region/all")}}',
            success: function(result){
                layer.close(ajaxLoad1);
                if (result.code > 0) {
                    layer.msg(result.msg);
                } else {
                    device_region_list = result.data;
                    var html='<option value="">请选择区域</option>';
                    $.each(result.data,function(key,value){
                        html+="<option value='"+value.id+"'>"+value.name+"</option>";
                    });
                    $('select[name=device_region_id]').html(html);
                    form.render("select");
                }
            }
        });
        // 监听区域选择
        form.on('select(device_region_id)', function(data){
            $.each(device_region_list,function(key,value){
                if(value.id == data.value){
                    var html='<option value="">请选择房间</option>';
                    $.each(device_region_list[key].device_room,function(k,v){
                        html+="<option value='"+v.id+"'>"+v.name+"</option>";
                    });
                    $('select[name=device_room_id]').html(html);
                    form.render("select");
                    return ;
                }
            });
        });   
        // 监听房间请求设备
        form.on('select(device_room_id)', function(data){
            // 监听房间选择
            ajaxLoad2 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
             $.ajax({ 
                type: "GET",
                url: '{{url("api/admin/device/all")}}?device_room_id='+data.value,
                success: function(result){
                    layer.close(ajaxLoad2);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        device_list = result.data;
                        var html='<option value="">请选择设备</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        });
                        $('select[name=device_id]').html(html);
                        form.render("select");
                    }
                }
            });
        });   
        // 监听触发设备选择
        form.on('select(device_id)', function(data){
            $.each(device_list,function(key,value){
                if(value.id == data.value){
                    var html='<option value="">请选择字段</option>';
                    $.each(device_list[key].device_field,function(k,v){
                        html+="<option value='"+v.id+"'>"+v.name+"</option>";
                    });
                    $('select[name=device_field_id]').html(html);
                    form.render("select");
                    return ;
                }
            });
            // 初始化响应设备
            var html='<option value="">请选择设备</option>';
            $.each(device_list,function(key,value){
                if(data.value != value.id){
                    html+="<option value='"+value.id+"'>"+value.name+"</option>";
                }
            });
            $('select[name=associated_device_id]').html(html);
            // 初始化响应设备字段
            $('select[name=associated_device_field_id]').html("<option value=''>请先选择设备</option>");
            form.render("select");
        });   
        // 监听设备1选择
        form.on('select(associated_device_id)', function(data){
            $.each(device_list,function(key,value){
                if(value.id == data.value){
                    var html='<option value="">请选择字段</option>';
                    $.each(device_list[key].device_field,function(k,v){
                        html+="<option value='"+v.id+"'>"+v.name+"</option>";
                    });
                    $('select[name=associated_device_field_id]').html(html);
                    form.render("select");
                    return ;
                }
            });
        });   
         //监听提交
         form.on('submit(formSubmit)', function(data) {
             formLoad = layer.load(1, {
                 shade: [0.8, '#393D49']
             });
             $.ajax({ 
                type: "POST",
                url: '{{url("api/admin/device/device_event")}}',
                data: {
                    'name': data.field.name,
                    'desc': data.field.desc,
                    'device_region_id': data.field.device_region_id,
                    'device_room_id': data.field.device_room_id,
                    // 触发设备
                    'device_id': data.field.device_id,
                    'device_field_id': data.field.device_field_id,
                    'type': data.field.type,
                    'value': data.field.value,
                    // 相应设备
                    'associated_device_id': data.field.associated_device_id,
                    'associated_device_field_id': data.field.associated_device_field_id,
                    'operation_type': data.field.operation_type,
                },
                success: function(result){
                    layer.close(formLoad);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                        parent.layer.close(index); //再执行关闭   
                    }
                }
            });
             return false;
         });
     </script>
 </body>

 </html>