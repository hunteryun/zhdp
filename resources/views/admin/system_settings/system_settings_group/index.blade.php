 <!DOCTYPE html>
 <html>

 <head>
     @include('admin.public.include_head')
 </head>

 <body>
     <div class="layui-card">
         <div class="layui-card-body">
            <div class="layui-row">
                <div class="layui-btn-container">
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-page">刷新页面</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-system_settings_group">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-system_settings_group">添加设置组</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="system_settings_group" lay-filter="system_settings_group"></table>
            </div>
         </div>
     </div>
     @include('admin.public.include_js')
     <script>
            table.render({
                elem: '#system_settings_group'
                ,url: '{{url('api/admin/system_settings/system_settings_group')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设置组名称'}
                    ,{field: 'field', title: '唯一标识'}
                    ,{field: 'desc', title: '设置组描述'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:150}
                ]]
            });
            table.on('tool(system_settings_group)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/admin/system_settings/system_settings_group")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('system_settings_group');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                } else if(obj.event === 'edit'){
                    window.edit_system_settings_group_info = data;
                    layer.open({
                        type:2,
                        title:'修改设备设置组',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("admin/system_settings/system_settings_group/edit")}}',
                        end:function(){
                            table.reload('system_settings_group');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-system_settings_group').click(function(){
                table.reload('system_settings_group');
            });
            // 添加设备
            $('#add-system_settings_group').click(function(){
                layer.open({
                    type:2,
                    title:'添加设备设置组',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("admin/system_settings/system_settings_group/add")}}',
                    end:function(){
                        table.reload('system_settings_group');
                    }
                });
            });
     </script>
 </body>

 </html>