 <!DOCTYPE html>
 <html>

 <head>
     @include('user.public.include_head')
 </head>

 <body class="layui-layout-body">
     <div class="layui-card">
         <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-device_event-event">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-device_event-event">添加设备事件</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="device_event" lay-filter="device_event"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device_event'
                ,url: '{{url('api/user/device/device_event')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备事件名称'}
                    ,{field: 'desc', title: '事件描述'}
                    ,{field: 'type', title: '设备事件类型', templet : function (d){
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
                    ,{field: 'associated_device.name', title: '响应设备', templet : function (d){
                        return d.associated_device.name;
                    }}
                    ,{field: 'associated_device_field.name', title: '响应字段', templet : function (d){
                        return d.associated_device_field.name;
                    }}
                    ,{field: 'operation_type', title: '触发操作', templet : function (d){
                        return d.operation_type == 1? '开': '关';
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(device_event)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/device/device_event")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('device_event');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'edit'){
                    window.edit_device_event_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备事件',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device/device_event/edit")}}',
                        end:function(){
                            table.reload('device_event');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device_event-event').click(function(){
                table.reload('device_event');
            });
            // 添加
            $('#add-device_event-event').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备事件',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/device/device_event/add")}}',
                    end:function(){
                        table.reload('device_event');
                    }
                });
            });
     </script>
 </body>

 </html>