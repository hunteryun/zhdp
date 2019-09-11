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
                    <button type="button" class="layui-btn layui-btn-sm" id="add-device-region">添加区域</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="device_region" lay-filter="device_region"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#device_region'
                ,url: '{{url('api/user/device_region')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '区域名称'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:150}
                ]]
            });
            table.on('tool(device_region)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                ajaxLoad = layer.load(1, {
                    shade: [0.8, '#393D49']
                });
                layer.confirm('真的删除行么', function(index){
                    $.ajax({ 
                        type: "POST",
                        url: '{{url("api/user/device_region")}}/'+ data.id,
                        data: {
                            '_method': 'DELETE',
                            'name': data.value,
                        },
                        success: function(result){
                            layer.close(ajaxLoad);
                            layer.msg(result.msg);
                            if (result.code == 0) {
                                table.reload('device_region');
                            }
                        }
                    });
                    layer.close(index);
                });
                } else if(obj.event === 'edit'){
                    layer.prompt({
                        title: '修改区域名称'
                        ,formType: 0
                        ,value: data.name
                    }, function(value, index){
                        ajaxLoad = layer.load(1, {
                            shade: [0.8, '#393D49']
                        });
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/device_region")}}/'+ data.id,
                            data: {
                                '_method': 'PUT',
                                'name': value,
                            },
                            success: function(result){
                                layer.close(ajaxLoad);
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    obj.update({
                                        name: value
                                    });
                                }
                            }
                        });
                        layer.close(index);
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-device-region').click(function(){
                table.reload('device_region');
            });
            // 添加设备
            $('#add-device-region').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备区域',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/device_region/add")}}',
                    end:function(){
                        table.reload('device_region');
                    }
                });
            });
     </script>
 </body>

 </html>