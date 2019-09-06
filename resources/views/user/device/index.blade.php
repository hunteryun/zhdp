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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-device-region">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加设备</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table id="device" lay-filter="device"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device'
                ,url: '{{url('api/user/device')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设备名称'}
                    ,{field: 'token', title: 'TOKEN'}
                    ,{field: 'desc', title: '设备描述'}
                    ,{field: 'device_room_name', title: '设备房间', templet : function (d){
                        return d.device_room.name;
                    }}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(device)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/device")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('device');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'view'){
                    window.edit_device_info = data;
                    layer.open({
                        type:2,
                        title:'查看设备',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device/device_field")}}',
                        end:function(){
                            table.reload('device');
                        }
                    });
                } else if(obj.event === 'edit'){
                    window.edit_device_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device/edit")}}',
                        end:function(){
                            table.reload('device');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device-region').click(function(){
                table.reload('device');
            });
            // 添加
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/device/add")}}',
                    end:function(){
                        table.reload('device');
                    }
                });
            });
     </script>
 </body>

 </html>