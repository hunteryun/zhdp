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
                    <button type="button" class="layui-btn layui-btn-sm" id="refresh-product-field-region">刷新表格</button> 
                </div>
            </div>
            <div class="layui-row">
                <script type="text/html" id="bar">
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
                <table lay-size="sm" id="device_field_log" lay-filter="device_field_log"></table>
            </div>
         </div>
     </div>
     @include('user.public.include_js')
     <script>
         var product_id = window.parent.product_id;
            table.render({
                elem: '#device_field_log'
                ,url: '{{url('api/user/device/device_field_log')}}'
                ,page: true 
                ,cols: [[ 
                    {field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'field', title: '标识符'}
                    ,{field: 'field_type.name', title: '字段类型', templet : function (d){
                        return d.field_type.name;
                    }}
                    ,{field: 'value', title: '值'}
                    ,{field: 'device.name', title: '设备名称', templet : function (d){
                        return d.device.name;
                    }}
                    ,{field: 'device.device_room.name', title: '房间名称', templet : function (d){
                        return d.device.device_room.name;
                    }}
                    // ,{field: 'common_field', title: '公共字段'}
                    // ,{field: 'common_field_sort', title: '公共字段排序'}
                    // ,{field: 'desc', title: '描述'}
                    ,{field: 'created_at', title: '时间'}
                    // ,{field: 'sort', title: '排序'}
                    ,{fixed: 'right', title:'操作', toolbar: '#bar', width:80}
                ]]
            });
            table.on('tool(device_field_log)', function(obj){
                var data = obj.data;
                if(obj.event === 'del'){
                    ajaxLoad = layer.load(1, {
                        shade: [0.8, '#393D49']
                    });
                    layer.confirm('真的删除行么', function(index){
                        $.ajax({ 
                            type: "POST",
                            url: '{{url("api/user/product/device_field_log")}}/'+ data.id,
                            data: {
                                '_method': 'DELETE',
                                'name': data.value,
                            },
                            success: function(result){
                                layer.msg(result.msg);
                                if (result.code == 0) {
                                    table.reload('device_field_log');
                                }
                            }
                        });
                        layer.close(index);
                    });
                    layer.close(ajaxLoad);
                }
            });
            // 刷新页面
            $('#refresh-page').click(function(){
                window.location.reload();
            });
            // 刷新列表
            $('#refresh-product-field-region').click(function(){
                table.reload('device_field_log');
            });
     </script>
 </body>

 </html>