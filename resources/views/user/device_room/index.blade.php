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
                    <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加房间</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="view">查看</a>
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="device_room" lay-filter="device_room"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device_room'
                ,url: '{{url('api/user/device_room')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '房间名称'}
                    ,{field: 'device_region_name', title: '区域名称', templet : function (d){
                        return d.device_region.name;
                    }}
                    ,{field: 'crop_class_name', title: '种植作物', templet : function (d){
                        return d.crop_class.name;
                    }}
                    ,{field: 'token', title: 'TOKEN'}
                    ,{field: 'desc', title: '房间描述'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:180}
                ]]
            });
            table.on('tool(device_room)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/device_room")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('device_room');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'view'){
                    window.device_room_info = data;
                    layer.open({
                        type:2,
                        title:'查看设备',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device_room/device")}}',
                        end:function(){
                            table.reload('device_room');
                        }
                    });
                } else if(obj.event === 'edit'){
                    window.edit_device_room_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备房间',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/device_room/edit")}}',
                        end:function(){
                            table.reload('device_room');
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
                table.reload('device_room');
            });
            // 添加设备
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备房间',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/device_room/add")}}',
                    end:function(){
                        table.reload('device_room');
                    }
                });
            });
     </script>
 </body>

 </html>