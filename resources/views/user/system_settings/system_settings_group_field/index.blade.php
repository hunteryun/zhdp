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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-system-settings-group-field">刷新表格</button> 
                    <button type="button" class="layui-btn layui-btn-sm" id="add-system-settings-group-field">添加设置</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="system_settings_group_field" lay-filter="system_settings_group_field"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
            table.render({
                elem: '#system_settings_group_field'
                ,url: '{{url('api/user/system_settings/system_settings_group_field')}}' 
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '设置名称'}
                    ,{field: 'system_settings_group.name', title: '设置组', templet : function (d){
                        return d.system_settings_group.name;
                    }}
                    ,{field: 'field', title: '唯一标识符'}
                    ,{field: 'desc', title: '设置描述'}
                    ,{field: 'type', title: '设置类型', templet : function (d){
                        if(d.type == 0){
                            return "普通文本";
                        }else if(d.type == 1){
                            return "文本域";
                        }if(d.type == 2){
                            return "单选";
                        }if(d.type == 3){
                            return "多选";
                        }
                    }}
                    ,{field: 'option', title: '选项'}
                    ,{field: 'value', title: '值'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:120}
                ]]
            });
            table.on('tool(system_settings_group_field)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/system_settings/system_settings_group_field")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('system_settings_group_field');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                }  else if(obj.event === 'edit'){
                    window.edit_system_settings_group_field_info = data;
                    layer.open({
                        type:2,
                        title:'修改设置',
                        shadeClose:true,
                        shade:0.8,
                        area:['100%','100%'],
                        content:'{{url("user/system_settings/system_settings_group_field/edit")}}',
                        end:function(){
                            table.reload('system_settings_group_field');
                        }
                    });
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-system-settings-group-field').click(function(){
                table.reload('system_settings_group_field');
            });
            // 添加
            $('#add-system-settings-group-field').click(function(){
                layer.open({
                    type:2,
                    title:'添加设置',
                    shadeClose:true,
                    shade:0.8,
                    area:['100%','100%'],
                    content:'{{url("user/system_settings/system_settings_group_field/add")}}',
                    end:function(){
                        table.reload('system_settings_group_field');
                    }
                });
            });
     </script>
 </body>

 </html>