 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <form class="layui-form">
                 <div class="layui-form-item">
                    <div class="layui-inline">
                        <div class="layui-btn-container">
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                            <button type="button" class="layui-btn layui-btn-sm" id="refresh-device_event_log-event">刷新表格</button> 
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <select name="device_region_id" id="device_region_id" lay-search lay-filter="device_region_id">
                            <option value="" selected>区域:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="device_room_id" id="device_room_id" lay-search lay-filter="device_room_id">
                            <option value="" selected>房间:请先选择区域.</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="product_id" id="product_id" lay-search lay-filter="product_id">
                            <option value="" selected>产品类型:加载中...</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="device_id" id="device_id" lay-search lay-filter="device_id">
                            <option value="" selected>设备:请先选择房间</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="device_field_id" id="device_field_id" lay-search lay-filter="device_field_id">
                            <option value="" selected>设备字段:请先选择设备</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <select name="type" id="type" lay-search lay-filter="type">
                            <option value="" selected>事件类型:不限</option>
                            <option value="0" >事件类型:低于阈值</option>
                            <option value="1" >事件类型:等于阈值</option>
                            <option value="2" >事件类型:高于阈值</option>
                        </select>
                    </div>
                    <div class="layui-inline">
                        <input type="text" name="name" autocomplete="off" placeholder="事件名" class="layui-input">
                    </div>
                    <div class="layui-inline">
                        <div class="layui-input-inline">
                        <button type="submit" id="submit" class="layui-btn" lay-submit="" lay-filter="formSubmit">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-row">
                <table lay-size="sm" id="device_event_log" lay-filter="device_event_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device_event_log'
                ,url: '{{url('api/user/device/device_event_log')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备事件日志名称'}
                    ,{field: 'desc', title: '事件描述'}
                    ,{field: 'type', title: '设备事件日志类型', templet : function (d){
                        if(d.type == 0){
                            return "低于阈值";
                        }
                        if(d.type == 1){
                            return "等于阈值";
                        }
                        if(d.type == 2){
                            return "高于阈值";
                        }
                    }}
                    ,{field: 'device.name', title: '触发设备', templet : function (d){
                        return d.device.name;
                    }}
                    ,{field: 'device_field.name', title: '触发字段', templet : function (d){
                        return d.device_field.name;
                    }}
                    ,{field: 'value', title: '触发阈值'}
                    ,{field: 'log_value', title: '记录值'}
                    ,{field: 'associated_device.name', title: '响应设备', templet : function (d){
                        return d.associated_device.name;
                    }}
                    ,{field: 'associated_device_field.name', title: '响应字段', templet : function (d){
                        return d.associated_device_field.name;
                    }}
                    ,{field: 'operation_type', title: '触发操作', templet : function (d){
                        return d.operation_type == 1? '开': '关';
                    }}
                ]]
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device_event_log-event').click(function(){
                table.reload('device_event_log');
            });
             // 获取区域分类
             ajaxLoad3 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/device_region/all")}}',
                success: function(result){
                    layer.close(ajaxLoad3);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>区域分类:不限区域</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=device_region_id]').html(html);
                        form.render("select");
                    }
                }
            });
            // 获取产品分类
            ajaxLoad6 = layer.load(1, {
                shade: [0.8, '#393D49']
            });
            $.ajax({ 
                type: "GET",
                url: '{{url("api/user/product/all")}}',
                success: function(result){
                    layer.close(ajaxLoad6);
                    if (result.code > 0) {
                        layer.msg(result.msg);
                    } else {
                        var html='<option value="" selected>产品分类:不限产品</option>';
                        $.each(result.data,function(key,value){
                            html+="<option value='"+value.id+"'>"+value.name+"</option>";
                        })
                        $('select[name=product_id]').html(html);
                        form.render("select");
                    }
                }
            });
            // 监听区域选择
            form.on('select(device_region_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device_room/all")}}?device_region_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>房间:不限房间</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=device_room_id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            // 监听房间选择
            form.on('select(device_room_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device/all")}}?device_room_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>设备:不限设备</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=device_id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            // 监听设备选择
            form.on('select(device_id)', function(data){
                ajaxLoad5 = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                $.ajax({ 
                    type: "GET",
                    url: '{{url("api/user/device/device_field/all")}}?device_id='+data.value,
                    success: function(result){
                        layer.close(ajaxLoad5);
                        if (result.code > 0) {
                            layer.msg(result.msg);
                        } else {
                            var html='<option value="" selected>字段:不限字段</option>';
                            $.each(result.data,function(key,value){
                                html+="<option value='"+value.id+"'>"+value.name+"</option>";
                            })
                            $('select[name=device_field_id]').html(html);
                            form.render("select");
                        }
                    }
                });
            });   
            //监听搜索
            form.on('submit(formSubmit)', function(data) {
                // 重载 table
                table.reload('device_event_log',{
                    where: {
                        'device_region_id': data.field.device_region_id,
                        'device_room_id': data.field.device_room_id,
                        'product_id': data.field.product_id,
                        'device_id': data.field.device_id,
                        'device_field_id': data.field.device_field_id,
                        'type': data.field.type,
                        'name': data.field.name,
                    }
                });
                return false;
            });
     </script>
 </body>

 </html>